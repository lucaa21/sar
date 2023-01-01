<?php

/* FOSUserBundle:Profile:show_content.html.twig */
class __TwigTemplate_82e34cc30104a036d7f14fa7a0dfb972a55468f64b92335c555d9a7b8a902058 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'User_body' => array($this, 'block_User_body'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Profile:show_content.html.twig"));

        // line 1
        echo " 
";
        // line 2
        $this->displayBlock('User_body', $context, $blocks);
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function block_User_body($context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "User_body"));

        // line 3
        echo "<div class=\"container\">
\t<div class=\"row clearfix\">
\t\t<div class=\"col-md-12 column\">
\t\t\t<div class=\"row clearfix\">
\t\t\t\t<div class=\"col-md-12 column\">
\t\t\t\t\t<table>
\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t<td class=\"col-md-12\">
\t\t\t\t\t\t\t\t<h3>
\t\t\t\t\t\t\t\t\tVotre profil
\t\t\t\t\t\t\t\t</h3>
\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t<td class=\"col-md-6\">
\t\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t</tr>
\t\t\t\t\t</table>
\t\t\t\t</div>
\t\t\t</div>
\t\t\t<div class=\"tabbable\" id=\"tabs-421784\">
\t\t\t\t<ul class=\"nav nav-tabs\">
\t\t\t\t\t<li class=\"active\">
\t\t\t\t\t\t<a href=\"#panel-375202\" data-toggle=\"tab\">Messages</a>
\t\t\t\t\t</li>\t\t\t\t
\t\t\t\t\t<li>
\t\t\t\t\t\t<a href=\"#panel-125027\" data-toggle=\"tab\">Profil</a>
\t\t\t\t\t</li>
\t\t\t\t\t<li>
\t\t\t\t\t\t<a href=\"#panel-125024\" data-toggle=\"tab\">Finances</a>
\t\t\t\t\t</li>
\t\t\t\t\t<li>
\t\t\t\t\t\t<a href=\"#panel-125030\" data-toggle=\"tab\">Mes Collègues</a>
\t\t\t\t\t</li>
\t\t\t\t\t<li>
\t\t\t\t\t\t<a href=\"#panel-125025\" data-toggle=\"tab\">Mes achats</a>
\t\t\t\t\t</li>
\t\t\t\t\t<li>
\t\t\t\t\t\t<a href=\"#panel-125026\" data-toggle=\"tab\">Mes ventes</a>
\t\t\t\t\t</li>
\t\t\t\t\t<li>
\t\t\t\t\t\t<a href=\"#panel-125029\" data-toggle=\"tab\">Mes crédits</a>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t\t<div class=\"tab-content\">
\t\t\t\t\t<div  class=\"tab-pane active\" id=\"panel-375202\">\t\t\t\t\t\t
\t\t\t\t\t\t";
        // line 48
        echo "\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"tab-pane\" id=\"panel-125024\">
\t\t\t\t\t\t<div class=\"panel panel-default\">
\t\t\t\t\t\t\t<div class=\"panel-body\">
\t\t\t\t\t\t\t\t<table class=\"table borderless\">
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 56
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("profile.show.credits", array(), "FOSUserBundle"), "html", null, true);
        echo "  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 59
        echo twig_escape_filter($this->env, $this->getAttribute(($context["user"] ?? $this->getContext($context, "user")), "credits", array()), "html", null, true);
        echo "    <a href=\"#\" class=\"btn btn-success\" role=\"button\">Virer mes crédits sur mon compten banque</a> </h4>\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 64
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("profile.show.name", array(), "FOSUserBundle"), "html", null, true);
        echo "  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 67
        echo twig_escape_filter($this->env, $this->getAttribute(($context["user"] ?? $this->getContext($context, "user")), "nom", array()), "html", null, true);
        echo "</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 72
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("profile.show.firstname", array(), "FOSUserBundle"), "html", null, true);
        echo "  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 75
        echo twig_escape_filter($this->env, $this->getAttribute(($context["user"] ?? $this->getContext($context, "user")), "prenom", array()), "html", null, true);
        echo "</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t</table>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"panel-footer\">
\t\t\t\t\t\t\t\tPanel footer
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>\t\t\t\t\t\t\t
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"tab-pane\" id=\"panel-125030\">";
        // line 86
        echo "\t\t\t\t\t\t\t";
        echo "\t\t\t\t\t\t\t
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"tab-pane\" id=\"panel-125025\">
\t\t\t\t\t\t\t";
        // line 89
        echo "\t\t\t\t\t\t\t
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"tab-pane\" id=\"panel-125026\">
\t\t\t\t\t\t\t";
        // line 92
        echo "\t\t\t\t\t\t\t
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"tab-pane\" id=\"panel-125027\">
\t\t\t\t\t\t<div class=\"panel panel-default\">\t\t\t\t\t
\t\t\t\t\t\t\t<div class=\"panel-body\">
\t\t\t\t\t\t\t\t<a class=\"btn btn-primary pull-right\" href=\"";
        // line 97
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("fos_user_profile_edit");
        echo "\">";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("profile.edit.edit", array(), "FOSUserBundle"), "html", null, true);
        echo "</a>\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<table class=\"table borderless\">
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 101
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("profile.show.username", array(), "FOSUserBundle"), "html", null, true);
        echo "  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 104
        echo twig_escape_filter($this->env, $this->getAttribute(($context["user"] ?? $this->getContext($context, "user")), "username", array()), "html", null, true);
        echo "</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 109
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("profile.show.email", array(), "FOSUserBundle"), "html", null, true);
        echo "  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 112
        echo twig_escape_filter($this->env, $this->getAttribute(($context["user"] ?? $this->getContext($context, "user")), "email", array()), "html", null, true);
        echo "</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 117
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("profile.show.activity", array(), "FOSUserBundle"), "html", null, true);
        echo "  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 120
        echo twig_escape_filter($this->env, $this->getAttribute(($context["user"] ?? $this->getContext($context, "user")), "activite", array()), "html", null, true);
        echo "</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 125
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("profile.show.targeted_opportunity", array(), "FOSUserBundle"), "html", null, true);
        echo "  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 128
        echo twig_escape_filter($this->env, $this->getAttribute(($context["user"] ?? $this->getContext($context, "user")), "descRech", array()), "html", null, true);
        echo "</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 133
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("profile.show.opportunity_tags", array(), "FOSUserBundle"), "html", null, true);
        echo "  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 136
        echo twig_escape_filter($this->env, $this->getAttribute(($context["user"] ?? $this->getContext($context, "user")), "tags", array()), "html", null, true);
        echo "</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 141
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("profile.show.targeted_activity", array(), "FOSUserBundle"), "html", null, true);
        echo "  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 144
        echo twig_escape_filter($this->env, $this->getAttribute(($context["user"] ?? $this->getContext($context, "user")), "actvise", array()), "html", null, true);
        echo "</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 149
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("profile.show.note", array(), "FOSUserBundle"), "html", null, true);
        echo "  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>";
        // line 152
        if (($this->getAttribute(($context["user"] ?? $this->getContext($context, "user")), "note", array()) < 1)) {
            echo "Vous n'avez pas encore été évalué.";
        } else {
            echo twig_escape_filter($this->env, $this->getAttribute(($context["user"] ?? $this->getContext($context, "user")), "note", array()), "html", null, true);
            echo " ";
        }
        echo "</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t</table>

\t\t\t\t\t\t\t\t<p>: </p>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"panel-footer\">
\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t</div>\t
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"tab-pane\" id=\"panel-125029\">
\t\t\t\t\t\t\t";
        // line 165
        echo "\t\t\t\t\t\t\t
\t\t\t\t\t</div>\t\t\t\t\t
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
</div>

";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Profile:show_content.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  280 => 165,  259 => 152,  253 => 149,  245 => 144,  239 => 141,  231 => 136,  225 => 133,  217 => 128,  211 => 125,  203 => 120,  197 => 117,  189 => 112,  183 => 109,  175 => 104,  169 => 101,  160 => 97,  153 => 92,  148 => 89,  142 => 86,  129 => 75,  123 => 72,  115 => 67,  109 => 64,  101 => 59,  95 => 56,  85 => 48,  38 => 3,  26 => 2,  23 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source(" 
{% block User_body %}
<div class=\"container\">
\t<div class=\"row clearfix\">
\t\t<div class=\"col-md-12 column\">
\t\t\t<div class=\"row clearfix\">
\t\t\t\t<div class=\"col-md-12 column\">
\t\t\t\t\t<table>
\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t<td class=\"col-md-12\">
\t\t\t\t\t\t\t\t<h3>
\t\t\t\t\t\t\t\t\tVotre profil
\t\t\t\t\t\t\t\t</h3>
\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t<td class=\"col-md-6\">
\t\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t</tr>
\t\t\t\t\t</table>
\t\t\t\t</div>
\t\t\t</div>
\t\t\t<div class=\"tabbable\" id=\"tabs-421784\">
\t\t\t\t<ul class=\"nav nav-tabs\">
\t\t\t\t\t<li class=\"active\">
\t\t\t\t\t\t<a href=\"#panel-375202\" data-toggle=\"tab\">Messages</a>
\t\t\t\t\t</li>\t\t\t\t
\t\t\t\t\t<li>
\t\t\t\t\t\t<a href=\"#panel-125027\" data-toggle=\"tab\">Profil</a>
\t\t\t\t\t</li>
\t\t\t\t\t<li>
\t\t\t\t\t\t<a href=\"#panel-125024\" data-toggle=\"tab\">Finances</a>
\t\t\t\t\t</li>
\t\t\t\t\t<li>
\t\t\t\t\t\t<a href=\"#panel-125030\" data-toggle=\"tab\">Mes Collègues</a>
\t\t\t\t\t</li>
\t\t\t\t\t<li>
\t\t\t\t\t\t<a href=\"#panel-125025\" data-toggle=\"tab\">Mes achats</a>
\t\t\t\t\t</li>
\t\t\t\t\t<li>
\t\t\t\t\t\t<a href=\"#panel-125026\" data-toggle=\"tab\">Mes ventes</a>
\t\t\t\t\t</li>
\t\t\t\t\t<li>
\t\t\t\t\t\t<a href=\"#panel-125029\" data-toggle=\"tab\">Mes crédits</a>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t\t<div class=\"tab-content\">
\t\t\t\t\t<div  class=\"tab-pane active\" id=\"panel-375202\">\t\t\t\t\t\t
\t\t\t\t\t\t{#{{ render(controller(\"BaclooCrmBundle:Crm:showmessages\" )) }}#}\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"tab-pane\" id=\"panel-125024\">
\t\t\t\t\t\t<div class=\"panel panel-default\">
\t\t\t\t\t\t\t<div class=\"panel-body\">
\t\t\t\t\t\t\t\t<table class=\"table borderless\">
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{{ 'profile.show.credits'|trans({}, 'FOSUserBundle') }}  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{{ user.credits }}    <a href=\"#\" class=\"btn btn-success\" role=\"button\">Virer mes crédits sur mon compten banque</a> </h4>\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{{ 'profile.show.name'|trans({}, 'FOSUserBundle') }}  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{{ user.nom }}</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{{ 'profile.show.firstname'|trans({}, 'FOSUserBundle') }}  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{{ user.prenom }}</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t</table>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"panel-footer\">
\t\t\t\t\t\t\t\tPanel footer
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>\t\t\t\t\t\t\t
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"tab-pane\" id=\"panel-125030\">{# #}
\t\t\t\t\t\t\t{# {{ render(controller(\"BaclooCrmBundle:Crm:showfavoris\" )) }} #}\t\t\t\t\t\t\t
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"tab-pane\" id=\"panel-125025\">
\t\t\t\t\t\t\t{# {{ render(controller(\"BaclooCrmBundle:Crm:showachats\", {'dix': 1} )) }} #}\t\t\t\t\t\t\t
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"tab-pane\" id=\"panel-125026\">
\t\t\t\t\t\t\t{# {{ render(controller(\"BaclooCrmBundle:Crm:showventes\" )) }} #}\t\t\t\t\t\t\t
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"tab-pane\" id=\"panel-125027\">
\t\t\t\t\t\t<div class=\"panel panel-default\">\t\t\t\t\t
\t\t\t\t\t\t\t<div class=\"panel-body\">
\t\t\t\t\t\t\t\t<a class=\"btn btn-primary pull-right\" href=\"{{ path('fos_user_profile_edit') }}\">{{ 'profile.edit.edit'|trans({}, 'FOSUserBundle') }}</a>\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<table class=\"table borderless\">
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{{ 'profile.show.username'|trans({}, 'FOSUserBundle') }}  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{{ user.username }}</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{{ 'profile.show.email'|trans({}, 'FOSUserBundle') }}  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{{ user.email }}</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{{ 'profile.show.activity'|trans({}, 'FOSUserBundle') }}  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{{ user.activite }}</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{{ 'profile.show.targeted_opportunity'|trans({}, 'FOSUserBundle') }}  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{{ user.descRech }}</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{{ 'profile.show.opportunity_tags'|trans({}, 'FOSUserBundle') }}  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{{ user.tags }}</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{{ 'profile.show.targeted_activity'|trans({}, 'FOSUserBundle') }}  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{{ user.actvise }}</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-3\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{{ 'profile.show.note'|trans({}, 'FOSUserBundle') }}  :</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"col-md-9\">
\t\t\t\t\t\t\t\t\t\t\t<h4>{% if user.note < 1 %}Vous n'avez pas encore été évalué.{% else %}{{ user.note }} {% endif %}</h4>
\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t</table>

\t\t\t\t\t\t\t\t<p>: </p>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"panel-footer\">
\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t</div>\t
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"tab-pane\" id=\"panel-125029\">
\t\t\t\t\t\t\t{# {{ render(controller(\"BaclooCrmBundle:Crm:showachatscredits\" )) }} #}\t\t\t\t\t\t\t
\t\t\t\t\t</div>\t\t\t\t\t
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
</div>

{% endblock %}", "FOSUserBundle:Profile:show_content.html.twig", "C:\\wamp\\www\\sar\\src\\Bacloo\\UserBundle/Resources/views/Profile/show_content.html.twig");
    }
}
