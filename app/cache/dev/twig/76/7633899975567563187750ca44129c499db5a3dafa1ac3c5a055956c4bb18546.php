<?php

/* ::layout.html.twig */
class __TwigTemplate_2c0c0210a6c8568c0843ea41884ef4b7a5e2c5f25a052de976291f75f552817a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "::layout.html.twig"));

        // line 2
        echo "<!DOCTYPE html>
<html>
\t<head>
\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
\t    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
\t<title>";
        // line 7
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
\t";
        // line 8
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 28
        echo "\t
<script src=\"https://js.stripe.com/v3/\"></script>
\t<script src=\"//code.jquery.com/jquery-1.10.2.js\"></script>
\t<script src=\"//code.jquery.com/ui/1.11.0/jquery-ui.js\"></script>
\t<script type=\"text/javascript\" src=\"";
        // line 32
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("js/jquery.ui.datepicker-fr.js"), "html", null, true);
        echo "\"></script>

\t<script type=\"text/javascript\" src=\"http://code.jquery.com/jquery-latest.min.js\"></script>
\t<script src=\"//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js\"></script>
\t<script src=\"//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js\"></script>
\t<script src=\"https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js\"></script>
\t





<!-- AddThisEvent -->
<script type=\"text/javascript\" src=\"https://addthisevent.com/libs/1.6.0/ate.min.js\"></script>
\t\t<!-- AddThisEvent theme css -->
\t\t<link rel=\"stylesheet\" href=\"";
        // line 47
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("css/addthisevent.theme8.css"), "html", null, true);
        echo "\" type=\"text/css\" media=\"screen\" />

\t\t<!-- AddThisEvent -->
\t\t<script type=\"text/javascript\" src=\"https://addthisevent.com/libs/ate-latest.min.js\"></script>

\t\t<!-- AddThisEvent Settings -->
\t\t<script type=\"text/javascript\">
\t\taddthisevent.settings({
\t\t\tlicense    : \"replace-with-your-licensekey\",
\t\t\tcss        : false,
\t\t\toutlook    : {show:true, text:\"Outlook\"},
\t\t\tgoogle     : {show:true, text:\"Google Agenda <em>(en ligne)</em>\"},
\t\t\tyahoo      : {show:true, text:\"Yahoo <em>(en ligne)</em>\"},
\t\t\toutlookcom : {show:true, text:\"Outlook.com <em>(en ligne)</em>\"},
\t\t\tappleical  : {show:true, text:\"Calendrier Apple\"},
\t\t\tdropdown   : {order:\"appleical,google,outlook,outlookcom,yahoo\"}
\t\t});
\t\t</script>


\t</head>
\t<body>
\t\t<div class=\"bacloo-section\">
\t\t  <div class=\"marges\">\t\t
\t\t\t<div class=\"row clearfix\">
\t\t\t\t<div class=\"col-md-12 column\">
\t\t\t\t\t<nav class=\"navbar navbar-default navbar-static-top\" role=\"navigation\">
\t\t\t\t\t\t<div class=\"navbar-header\">
\t\t\t\t\t\t\t <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#bs-example-navbar-collapse-1\"> <span class=\"sr-only\">Toggle navigation</span><span class=\"icon-bar\"></span><span class=\"icon-bar\"></span><span class=\"icon-bar\"></span></button>
\t\t\t\t\t\t\t <a class=\"navbar-brand\" href=\"";
        // line 76
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("bacloocrm_home");
        echo "\"><i class=\"fa fa-home\" aria-hidden=\"true\"></i></a>
\t\t\t\t\t\t</div>\t
\t\t\t\t\t\t\t<ul class=\"nav navbar-nav navbar-right\">\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<li>
\t\t\t\t\t\t\t\t\t<a href=\"";
        // line 80
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("fos_user_security_logout");
        echo "\"><span class=\"glyphicon glyphicon-log-out\" aria-hidden=\"true\"></span></a>
\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t</ul>\t\t\t
\t\t\t\t\t</nav>
\t\t\t\t\t
\t\t\t\t\t<!-- Fiche Body -->

\t\t\t\t\t";
        // line 87
        $this->displayBlock('body', $context, $blocks);
        // line 89
        echo "
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
</div>
\t\t<!-- Footer -->
\t\t<footer class=\"footer\">
\t\t
\t\t  <div class=\"navbar navbar-static-bottom\">
\t\t\t<div class=\"container\">
\t\t\t\t<center>\t
\t\t\t\t\t<p>Copyright &copy; SAR ";
        // line 100
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y"), "html", null, true);
        echo " | Un bas de page </p>
\t\t\t\t</center>
\t\t\t</div>
\t\t\t
\t\t\t
\t\t  </div>\t\t
\t\t
\t\t\t<div class=\"container text-center\">
\t\t\t\t
\t\t\t</div>
\t\t</footer>

\t\t";
        // line 112
        $this->displayBlock('javascripts', $context, $blocks);
        // line 137
        echo "\t

\t</body>
</html>";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "SAR";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 8
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 9
        echo "\t<link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("css/bootstrap.css"), "html", null, true);
        echo "\"type=\"text/css\" />
\t<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css\">
\t<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.css\">
\t<link href=\"https://fonts.googleapis.com/icon?family=Material+Icons\" rel=\"stylesheet\">
\t<link rel=\"stylesheet\" href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("assets/dropzone.min.css"), "html", null, true);
        echo "\">
\t    <!-- Custom CSS -->
    <link href=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("css/sb-admin.css"), "html", null, true);
        echo "\"type=\"text/css\" />
    <link href=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("css/morris.css"), "html", null, true);
        echo "\"type=\"text/css\" />
\t<link href=\"";
        // line 17
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("css/fullsar.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
\t<link href=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("css/global.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
\t<link href=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("css/normalize.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
\t<link rel=\"stylesheet\" href=\"//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css\">
\t    <!-- Side menu -->\t
\t<link href=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("css/slidemenu.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
\t<link href=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("css/dropzone.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
\t
\t<link rel=\"stylesheet\"  href=\"https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css\" type=\"text/css\" media=\"all\"/>
\t<link rel=\"icon\" href=\"";
        // line 26
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
\t";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 87
    public function block_body($context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 88
        echo "\t\t\t\t\t";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 112
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        // line 113
        echo "\t\t";
        // line 115
        echo "\t\t";
        // line 116
        echo "\t\t<script type=\"text/javascript\" src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("js/bootstrap.js"), "html", null, true);
        echo "\"></script>
\t\t<script type=\"text/javascript\" src=\"";
        // line 117
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("js/jquery-ui-1.10.4.custom.js"), "html", null, true);
        echo "\"></script>
\t\t<script type=\"text/javascript\" src=\"";
        // line 118
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("js/jquery-ui-1.10.4.custom.min.js"), "html", null, true);
        echo "\"></script>
\t\t<script type=\"text/javascript\" src=\"";
        // line 119
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("js/jquery.slidemenu.js"), "html", null, true);
        echo "\"></script>

<!-- jQuery is necessary -->
";
        // line 123
        echo "

\t
\t\t<script>
\t\t  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
\t\t  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
\t\t  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
\t\t  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

\t\t  ga('create', 'UA-65993029-1', 'auto');
\t\t  ga('send', 'pageview');

\t\t</script>  \t
\t\t\t
\t\t";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "::layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  268 => 123,  262 => 119,  258 => 118,  254 => 117,  249 => 116,  247 => 115,  245 => 113,  239 => 112,  232 => 88,  226 => 87,  217 => 26,  211 => 23,  207 => 22,  201 => 19,  197 => 18,  193 => 17,  189 => 16,  185 => 15,  180 => 13,  172 => 9,  166 => 8,  154 => 7,  144 => 137,  142 => 112,  127 => 100,  114 => 89,  112 => 87,  102 => 80,  95 => 76,  63 => 47,  45 => 32,  39 => 28,  37 => 8,  33 => 7,  26 => 2,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{# app/Resources/views/layout.html.twig #}
<!DOCTYPE html>
<html>
\t<head>
\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
\t    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
\t<title>{% block title %}SAR{% endblock %}</title>
\t{% block stylesheets %}
\t<link rel=\"stylesheet\" href=\"{{ asset('css/bootstrap.css') }}\"type=\"text/css\" />
\t<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css\">
\t<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.css\">
\t<link href=\"https://fonts.googleapis.com/icon?family=Material+Icons\" rel=\"stylesheet\">
\t<link rel=\"stylesheet\" href=\"{{ asset('assets/dropzone.min.css') }}\">
\t    <!-- Custom CSS -->
    <link href=\"{{ asset('css/sb-admin.css') }}\"type=\"text/css\" />
    <link href=\"{{ asset('css/morris.css') }}\"type=\"text/css\" />
\t<link href=\"{{ asset('css/fullsar.css') }}\" rel=\"stylesheet\">
\t<link href=\"{{ asset('css/global.css') }}\" rel=\"stylesheet\">
\t<link href=\"{{ asset('css/normalize.css') }}\" rel=\"stylesheet\">
\t<link rel=\"stylesheet\" href=\"//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css\">
\t    <!-- Side menu -->\t
\t<link href=\"{{ asset('css/slidemenu.css') }}\" rel=\"stylesheet\">
\t<link href=\"{{ asset('css/dropzone.css') }}\" rel=\"stylesheet\">
\t
\t<link rel=\"stylesheet\"  href=\"https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css\" type=\"text/css\" media=\"all\"/>
\t<link rel=\"icon\" href=\"{{ asset('favicon.ico') }}\" />
\t{% endblock %}
\t
<script src=\"https://js.stripe.com/v3/\"></script>
\t<script src=\"//code.jquery.com/jquery-1.10.2.js\"></script>
\t<script src=\"//code.jquery.com/ui/1.11.0/jquery-ui.js\"></script>
\t<script type=\"text/javascript\" src=\"{{ asset('js/jquery.ui.datepicker-fr.js') }}\"></script>

\t<script type=\"text/javascript\" src=\"http://code.jquery.com/jquery-latest.min.js\"></script>
\t<script src=\"//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js\"></script>
\t<script src=\"//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js\"></script>
\t<script src=\"https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js\"></script>
\t





<!-- AddThisEvent -->
<script type=\"text/javascript\" src=\"https://addthisevent.com/libs/1.6.0/ate.min.js\"></script>
\t\t<!-- AddThisEvent theme css -->
\t\t<link rel=\"stylesheet\" href=\"{{ asset('css/addthisevent.theme8.css') }}\" type=\"text/css\" media=\"screen\" />

\t\t<!-- AddThisEvent -->
\t\t<script type=\"text/javascript\" src=\"https://addthisevent.com/libs/ate-latest.min.js\"></script>

\t\t<!-- AddThisEvent Settings -->
\t\t<script type=\"text/javascript\">
\t\taddthisevent.settings({
\t\t\tlicense    : \"replace-with-your-licensekey\",
\t\t\tcss        : false,
\t\t\toutlook    : {show:true, text:\"Outlook\"},
\t\t\tgoogle     : {show:true, text:\"Google Agenda <em>(en ligne)</em>\"},
\t\t\tyahoo      : {show:true, text:\"Yahoo <em>(en ligne)</em>\"},
\t\t\toutlookcom : {show:true, text:\"Outlook.com <em>(en ligne)</em>\"},
\t\t\tappleical  : {show:true, text:\"Calendrier Apple\"},
\t\t\tdropdown   : {order:\"appleical,google,outlook,outlookcom,yahoo\"}
\t\t});
\t\t</script>


\t</head>
\t<body>
\t\t<div class=\"bacloo-section\">
\t\t  <div class=\"marges\">\t\t
\t\t\t<div class=\"row clearfix\">
\t\t\t\t<div class=\"col-md-12 column\">
\t\t\t\t\t<nav class=\"navbar navbar-default navbar-static-top\" role=\"navigation\">
\t\t\t\t\t\t<div class=\"navbar-header\">
\t\t\t\t\t\t\t <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#bs-example-navbar-collapse-1\"> <span class=\"sr-only\">Toggle navigation</span><span class=\"icon-bar\"></span><span class=\"icon-bar\"></span><span class=\"icon-bar\"></span></button>
\t\t\t\t\t\t\t <a class=\"navbar-brand\" href=\"{{ path('bacloocrm_home') }}\"><i class=\"fa fa-home\" aria-hidden=\"true\"></i></a>
\t\t\t\t\t\t</div>\t
\t\t\t\t\t\t\t<ul class=\"nav navbar-nav navbar-right\">\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<li>
\t\t\t\t\t\t\t\t\t<a href=\"{{ path('fos_user_security_logout') }}\"><span class=\"glyphicon glyphicon-log-out\" aria-hidden=\"true\"></span></a>
\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t</ul>\t\t\t
\t\t\t\t\t</nav>
\t\t\t\t\t
\t\t\t\t\t<!-- Fiche Body -->

\t\t\t\t\t{% block body %}
\t\t\t\t\t{% endblock %}

\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
</div>
\t\t<!-- Footer -->
\t\t<footer class=\"footer\">
\t\t
\t\t  <div class=\"navbar navbar-static-bottom\">
\t\t\t<div class=\"container\">
\t\t\t\t<center>\t
\t\t\t\t\t<p>Copyright &copy; SAR {{ \"now\"|date(\"Y\") }} | Un bas de page </p>
\t\t\t\t</center>
\t\t\t</div>
\t\t\t
\t\t\t
\t\t  </div>\t\t
\t\t
\t\t\t<div class=\"container text-center\">
\t\t\t\t
\t\t\t</div>
\t\t</footer>

\t\t{% block javascripts %}
\t\t{# Ajoutez ces lignes JavaScript si vous comptez vous servir des
\t\tfonctionnalités du bootstrap Twitter #}
\t\t{#<script src=\"//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js\"></script> #}
\t\t<script type=\"text/javascript\" src=\"{{ asset('js/bootstrap.js') }}\"></script>
\t\t<script type=\"text/javascript\" src=\"{{ asset('js/jquery-ui-1.10.4.custom.js') }}\"></script>
\t\t<script type=\"text/javascript\" src=\"{{ asset('js/jquery-ui-1.10.4.custom.min.js') }}\"></script>
\t\t<script type=\"text/javascript\" src=\"{{ asset('js/jquery.slidemenu.js') }}\"></script>

<!-- jQuery is necessary -->
{# <script type=\"text/javascript\" src=\"https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js\"></script>  #}


\t
\t\t<script>
\t\t  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
\t\t  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
\t\t  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
\t\t  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

\t\t  ga('create', 'UA-65993029-1', 'auto');
\t\t  ga('send', 'pageview');

\t\t</script>  \t
\t\t\t
\t\t{% endblock %}\t

\t</body>
</html>", "::layout.html.twig", "C:\\wamp\\www\\sar\\app/Resources\\views/layout.html.twig");
    }
}
