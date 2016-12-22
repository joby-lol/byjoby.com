<?php

/* blog.twig */
class __TwigTemplate_9b6cfebb851f9505558ae99c0c4fb240ac4849928f902d04c7bb54f25d4f94e5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("default.twig", "blog.twig", 1);
        $this->blocks = array(
            'navigation' => array($this, 'block_navigation'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "default.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_navigation($context, array $blocks = array())
    {
        // line 4
        echo "    <nav role=\"navigation\">
        <div role=\"menubar\">
            <a role=\"menuitem\" href=\"/blog/\" aria-selected=\"true\">Blog</a>
            <a role=\"menuitem\" href=\"/cv/\">CV</a>
            <a role=\"menuitem\" href=\"/test/\">Test</a>
        </div>
    </nav>
";
    }

    public function getTemplateName()
    {
        return "blog.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 4,  28 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "blog.twig", "C:\\Users\\elhober\\Dropbox\\_Uniserver_XII\\vhosts\\www.byjoby.com\\templates\\blog.twig");
    }
}
