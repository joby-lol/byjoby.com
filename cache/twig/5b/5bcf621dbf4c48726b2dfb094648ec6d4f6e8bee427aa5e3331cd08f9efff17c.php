<?php

/* default.twig */
class __TwigTemplate_0ad57fdde66bc26d88e5dad11a545ea5a36c4a5dd29f54c2ab9d3c182dd48067 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'banner' => array($this, 'block_banner'),
            'navigation' => array($this, 'block_navigation'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
    <title>";
        // line 4
        echo twig_escape_filter($this->env, ($context["page_title"] ?? null), "html", null, true);
        echo " :: ";
        echo twig_escape_filter($this->env, ($context["site_name"] ?? null), "html", null, true);
        echo "</title>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <meta name=\"theme-color\" content=\"#C42F1E\">
    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css\">
    <link rel=\"stylesheet\" href=\"/css/hs/hs-typography.css\">
    <link rel=\"stylesheet\" href=\"/css/hs/hs-menus.css\">
    <link rel=\"stylesheet\" href=\"/css/hs/hs-fa-linkicons.css\">
    <link rel=\"stylesheet\" href=\"/css/hs/hs-layout-1col.css\">
    <link rel=\"stylesheet\" href=\"/css/main.css\">
</head>
<body>

";
        // line 17
        $this->displayBlock('banner', $context, $blocks);
        // line 22
        echo "
";
        // line 23
        $this->displayBlock('navigation', $context, $blocks);
        // line 32
        echo "
    <main role=\"main\">
        ";
        // line 34
        echo ($context["page_body"] ?? null);
        echo "
    </main>

    <footer role=\"contentinfo\">
        &copy; Joby Elliott
    </footer>

</body>
</html>
";
    }

    // line 17
    public function block_banner($context, array $blocks = array())
    {
        // line 18
        echo "    <header role=\"banner\">
        <h1><a href=\"/\">*joby_elliott</a></h1>
    </header>
";
    }

    // line 23
    public function block_navigation($context, array $blocks = array())
    {
        // line 24
        echo "    <nav role=\"navigation\">
        <div role=\"menubar\">
            <a role=\"menuitem\" href=\"/blog/\">Blog</a>
            <a role=\"menuitem\" href=\"/cv/\">CV</a>
            <a role=\"menuitem\" href=\"/test/\">Test</a>
        </div>
    </nav>
";
    }

    public function getTemplateName()
    {
        return "default.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  82 => 24,  79 => 23,  72 => 18,  69 => 17,  55 => 34,  51 => 32,  49 => 23,  46 => 22,  44 => 17,  26 => 4,  21 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "default.twig", "C:\\Users\\elhober\\Dropbox\\_Uniserver_XII\\vhosts\\www.byjoby.com\\templates\\default.twig");
    }
}
