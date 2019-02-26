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


class TemplateController extends BaseController
{
	const TEMPLATE_DIRECTORY = __DIR__.'/../../../site/templates';
	public function listTemplates(){

		return $this->view()->render($this->response(), "auth/templates/list.twig", ["templates" => self::getTemplates()]);
	}

	public function addTemplate(){

	}

	public function editTemplate(){

		$template = Yaml::parseFile(base64_decode($this->arguments()->get('template')));

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
		$template['fields'] = array_values(array_filter($template['fields'], function($f){
			return !in_array($f['name'], ["title"]);
		}));

		$fieldConfigs = array_map(function(string $field){
			return $field::renderOptions();
		}, $fields);

		return $this->view()->render($this->response(), "auth/templates/edit.twig", ["template" => $template, "fieldsOptions" => $fieldsOptions, "fieldList" => $fieldList, "fieldConfigs" => $fieldConfigs]);
	}

	public static function getTemplates(){
		$it = new \RecursiveDirectoryIterator(self::TEMPLATE_DIRECTORY);
		$templates = [];
		foreach (new \RecursiveIteratorIterator($it) as $file) {
			if($file instanceof \SplFileInfo){
				if($file->isFile() && $file->getExtension() == "yml"){
					$template = Yaml::parseFile($file->getRealPath());
					$template['_id'] = base64_encode($file->getRealPath());
					$templates[] = $template;
				}
			}
		}
		return $templates;
	}

}