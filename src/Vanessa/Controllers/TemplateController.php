<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-25
 * Time: 17:52
 */

namespace Vanessa\Controllers;


use Symfony\Component\Yaml\Yaml;
use Vanessa\Core\BaseController;
use Vanessa\Core\Inputfield\InputFieldLoad;
use Webuni\FrontMatter\Document;
use Webuni\FrontMatter\FrontMatter;


class TemplateController extends BaseController
{
	const TEMPLATE_DIRECTORY = __DIR__.'/../../../site/templates';
	public function listTemplates(){

		return $this->view()->render($this->response(), "auth/templates/list.twig", ["templates" => self::getTemplates()]);
	}

	public function addTemplate(){

	}

	public function editTemplate(){
		$frontMatter = new FrontMatter();
		$file = base64_decode($this->arguments()->get('template'));
		$template = $frontMatter->parse(file_get_contents($file));

		if($this->request()->isPost()){
			$old = $template->getData();
			$post = $this->request()->getParsedBody();
			$fields = [];
			$row = [];
			foreach($post['fields'] as $fieldGroup){
				foreach($fieldGroup as $key => $field) {
					//It's ending here so we reset the row
					$row[$key] = $key == "_options" ? json_decode($field, true) : $field;
					if ($key == "_options") {
						$fields[] = $row;
						$row = [];
					}
				}
			}

			foreach($fields as $k => $field) {
				$options = $field['_options'];
				unset($field['_options']);
				$fields[$k] = array_replace($options, $field);

			}
			$post['fields'] = $fields;


			$template->setData( array_replace_recursive($old, $post));

			file_put_contents($file, $frontMatter->dump($template));
		}

		$templateSettings = $template->getData();

		$fields = InputFieldLoad::all();

		//Render the options
		$fieldsOptions = array_map(function(string $field){
			return $field::renderAdd();
		}, $fields);
		usort($fieldsOptions, function($a, $b){
			return $a['sort'] <=> $b['sort'];
		});

		//Render all listItems
		$fieldList = array_map(function(string $field){
			return $field::renderListItem();
		}, $fields);

		//Remove some fields
		$templateFields['fields'] = array_values(array_filter($templateSettings['fields'], function($f){
			return !in_array($f['name'], ["title"]);
		}));

		$fieldConfigs = array_map(function(string $field){
			return $field::renderOptions();
		}, $fields);

		return $this->view()->render($this->response(), "auth/templates/edit.twig", ["template" => $templateSettings, "fieldsOptions" => $fieldsOptions, "fieldList" => $fieldList, "fieldConfigs" => $fieldConfigs]);
	}

	public static function getTemplates(){
		$it = new \RecursiveDirectoryIterator(self::TEMPLATE_DIRECTORY);
		$templates = [];
		foreach (new \RecursiveIteratorIterator($it) as $file) {
			if($file instanceof \SplFileInfo){
				if($file->isFile() && $file->getExtension() == "yml"){
					$frontMatter = new FrontMatter();
					$template = $frontMatter->parse(file_get_contents($file->getRealPath()))->getData();
					$template['_id'] = base64_encode($file->getRealPath());
					$templates[] = $template;
				}
			}
		}
		return $templates;
	}

}