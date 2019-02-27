<?php
/**
 * Created by PhpStorm.
 * User: maxallan
 * Date: 2019-02-24
 * Time: 21:36
 */

namespace Vanessa\Core;


use Mni\FrontYAML\Document;
use Mni\FrontYAML\Parser;
use Symfony\Component\Yaml\Yaml;
use Webuni\FrontMatter\FrontMatter;

class Generator
{
	const DIR = __DIR__.'/../../site/';
	const OUT_DIR = __DIR__.'/../../public_html/';

	private $path;
	private $content;
	private $template;

	public function __construct(string $path)
	{

		$this->path = $path;
		$this->loadContent(self::DIR.'content/'.$path."/index.md");
		$this->loadTemplate();
		$this->generateOutput();
	}

	private function loadContent($file){
		$this->content = (new FrontMatter())->parse(file_get_contents($file));
		if($this->content instanceof Document){
			if(!$this->content->getYAML()['template']){
				throw new \Exception("No template found");
			}
		}
	}

	private function loadTemplate(){
		$this->template = Yaml::parseFile(self::DIR.'templates/'.$this->content->getYAML()['template'].'.yml');
	}

	private function generateOutput(){
		$loader = new \Twig\Loader\FilesystemLoader(self::DIR.'layouts/');
		$twig = new \Twig\Environment($loader);

		$layout = $twig->load($this->template['layout'].'.twig');

		$variables = $this->content->getYAML();
		if(!$this->template['hide_content']){
			$variables = array_merge($variables, ["content" => $this->content->getContent()]);
		}
		$variables = ["page" => $variables];
		$content = $layout->render($variables);

		if($this->path === "index"){
			file_put_contents(self::OUT_DIR.'index.html', $content);
		}else{
			if(!file_exists(self::OUT_DIR.$this->path)){
				mkdir(self::OUT_DIR.$this->path, 0777, true);
			}
			file_put_contents(self::OUT_DIR.$this->path.'/index.html', $content);
		}
	}
}