<?php

/* index.php */
class __TwigTemplate_79c9f24021077535332d3b6cd4447b87d203d208220777364304b52ec9d6668d extends Twig_Template
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
        echo twig_escape_filter($this->env, (isset($context["st"]) ? $context["st"] : null), "html", null, true);
        echo "
hehe";
    }

    public function getTemplateName()
    {
        return "index.php";
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
/* {{st}}*/
/* hehe*/
