<?php

/* BaclooCrmBundle:Crm:removeMission.html.twig */
class __TwigTemplate_8fe0511adb9e234de27ee04f398a905b02061a579b351791bca6eb34e1a0add7 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("BaclooCrmBundle::layout.html.twig", "BaclooCrmBundle:Crm:removeMission.html.twig", 1);
        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "BaclooCrmBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "BaclooCrmBundle:Crm:removeMission.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 2
    public function block_body($context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 3
        if ((($context["check"] ?? $this->getContext($context, "check")) == "1")) {
            echo " ";
            // line 4
            echo "\t<div class=\"row clearfix\">
\t\t\t\t<div class=\"modal-dialog\">
\t\t\t\t\t<div class=\"modal-content\">
\t\t\t\t\t\t\t<div class=\"modal-header\">
\t\t\t\t\t\t\t\t <a class=\"close\" href=\"";
            // line 8
            echo twig_escape_filter($this->env, ($context["previous"] ?? $this->getContext($context, "previous")), "html", null, true);
            echo "\">×</a>
\t\t\t\t\t\t\t\t<h4 class=\"modal-title\" id=\"myModalLabel\">
\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t</h4>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"modal-body\">
\t\t\t\t\t\t\t\tÊtes vous sûr de vouloir supprimer cette mission ?
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"modal-footer\">
\t\t\t\t\t\t\t<center>
\t\t\t\t\t\t\t\t<a class=\"btn btn-danger\" href=\"";
            // line 18
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("bacloocrm_removemission", array("id" => ($context["id"] ?? $this->getContext($context, "id")), "check" => "ok")), "html", null, true);
            echo "\"><span>Oui</span></a>  
\t\t\t\t\t\t\t\t<a class=\"btn btn-primary\" href=\"";
            // line 19
            echo twig_escape_filter($this->env, ($context["previous"] ?? $this->getContext($context, "previous")), "html", null, true);
            echo "\"><span>Non</span></a>
\t\t\t\t\t\t\t</center>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t</div>\t\t\t\t\t
\t\t\t\t</div>\t\t\t\t
\t</div>
";
        } else {
            // line 25
            echo "  ";
            // line 26
            echo "\t<div class=\"row clearfix\">
\t\t\t\t<div class=\"modal-dialog\">
\t\t\t\t\t<div class=\"modal-content\">
\t\t\t\t\t\t\t<div class=\"modal-header\">
\t\t\t\t\t\t\t\t <a class=\"close\" href=\"";
            // line 30
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("bacloocrm_agence");
            echo "\">×</a>
\t\t\t\t\t\t\t\t<h4 class=\"modal-title\" id=\"myModalLabel\">
\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t</h4>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"modal-body\">
\t\t\t\t\t\t\t\tLa mission a bien été supprimée.
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"modal-footer\">
\t\t\t\t\t\t\t\t<a class=\"btn btn-primary\" href=\"";
            // line 39
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("bacloocrm_agence");
            echo "\"><span>Fermer</span></a>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t</div>\t\t\t\t\t
\t\t\t\t</div>\t\t\t\t
\t</div>
";
        }
        // line 44
        echo "\t
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "BaclooCrmBundle:Crm:removeMission.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  105 => 44,  96 => 39,  84 => 30,  78 => 26,  76 => 25,  66 => 19,  62 => 18,  49 => 8,  43 => 4,  40 => 3,  34 => 2,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"BaclooCrmBundle::layout.html.twig\" %}
{% block body %}
{% if check == '1' %} {# QUand on a cliqué sur Supprimer #}
\t<div class=\"row clearfix\">
\t\t\t\t<div class=\"modal-dialog\">
\t\t\t\t\t<div class=\"modal-content\">
\t\t\t\t\t\t\t<div class=\"modal-header\">
\t\t\t\t\t\t\t\t <a class=\"close\" href=\"{{ previous }}\">×</a>
\t\t\t\t\t\t\t\t<h4 class=\"modal-title\" id=\"myModalLabel\">
\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t</h4>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"modal-body\">
\t\t\t\t\t\t\t\tÊtes vous sûr de vouloir supprimer cette mission ?
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"modal-footer\">
\t\t\t\t\t\t\t<center>
\t\t\t\t\t\t\t\t<a class=\"btn btn-danger\" href=\"{{ path('bacloocrm_removemission', {'id': id, 'check': 'ok'}) }}\"><span>Oui</span></a>  
\t\t\t\t\t\t\t\t<a class=\"btn btn-primary\" href=\"{{ previous}}\"><span>Non</span></a>
\t\t\t\t\t\t\t</center>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t</div>\t\t\t\t\t
\t\t\t\t</div>\t\t\t\t
\t</div>
{% else %}  {# Suppression bien effectuée #}
\t<div class=\"row clearfix\">
\t\t\t\t<div class=\"modal-dialog\">
\t\t\t\t\t<div class=\"modal-content\">
\t\t\t\t\t\t\t<div class=\"modal-header\">
\t\t\t\t\t\t\t\t <a class=\"close\" href=\"{{ path('bacloocrm_agence') }}\">×</a>
\t\t\t\t\t\t\t\t<h4 class=\"modal-title\" id=\"myModalLabel\">
\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t</h4>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"modal-body\">
\t\t\t\t\t\t\t\tLa mission a bien été supprimée.
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"modal-footer\">
\t\t\t\t\t\t\t\t<a class=\"btn btn-primary\" href=\"{{ path('bacloocrm_agence') }}\"><span>Fermer</span></a>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t</div>\t\t\t\t\t
\t\t\t\t</div>\t\t\t\t
\t</div>
{% endif %}\t
{% endblock %}", "BaclooCrmBundle:Crm:removeMission.html.twig", "C:\\wamp\\www\\sar\\src\\Bacloo\\CrmBundle/Resources/views/Crm/removeMission.html.twig");
    }
}
