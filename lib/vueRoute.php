<?php
require_once "../lib/scss/scss.php";
use ScssPhp\ScssPhp\Compiler;
class vueRoute {

    private $routes;
    private $vueComponent;

    public function __construct() {
        $this->vueComponent = new vueComponent();
    }

    function exec($type) {
        if ($type == "js") {
            header("Content-type: text/javascript", true);
            $str = "";
            $js = $this->vueComponent->convertJS("App.vue");
            foreach ($this->routes as $route) {
                $str .= " { path: '{$route["path"]}', component: {$route["component"]} },";

                $js .= $this->vueComponent->convertJS($route["dir"] . "{$route["component"]}.vue");
            }

            echo $js;
            echo "const router = new VueRouter({
                mode: 'history',
                routes: [
            {$str}
                ]
              })";

            echo "
        var app = new Vue({
                router,
                'el': '#app',
                components: {
                    App
                },
            })";
        } else if ($type == "css") {
            header("Content-type: text/css", true);
            $css =  $this->vueComponent->convertCSS("App.vue");
            foreach ($this->routes as $route) {
                $css .= $this->vueComponent->convertCSS($route["dir"] . "{$route["component"]}.vue");
            }
            $this->importCSS($css);
        }
    }

    function addRoute($path, $component, $dir = "") {
        $this->routes[] = [
            "path" => $path,
            "component" => $component,
            "dir" => $dir
        ];
    }
    
    function importCSS($vueSCSS) {

        $scss = new Compiler();

        $scssIn = file_get_contents("../assets/scss/main.scss");
        $scssIn .= $vueSCSS;
        $cssOut = $scss->compile($scssIn);

        echo $cssOut;
    }

}




