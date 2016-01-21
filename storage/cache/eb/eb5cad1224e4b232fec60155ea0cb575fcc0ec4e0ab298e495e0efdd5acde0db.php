<?php

/* abc/index.php */
class __TwigTemplate_69c25385e5e06df214ee33eddd31d4e31e167ad37a631b8532b5afb0c71b2a1e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<a href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('slim')->pathFor("/jsob/test"), "html", null, true);
        echo "\">Josh</a>";
    }

    public function getTemplateName()
    {
        return "abc/index.php";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
/* <a href="{{ path_for('/jsob/test')}}">Josh</a>*/
