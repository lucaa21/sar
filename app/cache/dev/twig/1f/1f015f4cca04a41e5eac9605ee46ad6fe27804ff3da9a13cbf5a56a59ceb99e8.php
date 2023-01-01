<?php

/* FOSUserBundle:Security:login.html.twig */
class __TwigTemplate_61e45dccd89982feb05c5488941e9288201faee2f0b5586a54801d6bf76a7426 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("FOSUserBundle::layout.html.twig", "FOSUserBundle:Security:login.html.twig", 1);
        $this->blocks = array(
            'fos_user_content' => array($this, 'block_fos_user_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "FOSUserBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Security:login.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 3
    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        // line 4
        echo "\t<h1 class=\"brand-heading\">";
        echo twig_escape_filter($this->env, ($context["societe"] ?? $this->getContext($context, "societe")), "html", null, true);
        echo "</h1>
\t<p class=\"intro-text\">";
        // line 5
        echo twig_escape_filter($this->env, ($context["text"] ?? $this->getContext($context, "text")), "html", null, true);
        echo "</p>
";
        // line 6
        if (($context["error"] ?? $this->getContext($context, "error"))) {
            // line 7
            echo "    <div>";
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans(($context["error"] ?? $this->getContext($context, "error")), array(), "FOSUserBundle"), "html", null, true);
            echo "</div>
";
        }
        // line 9
        echo "<div class=\"container-full\">
      <div class=\"row\">      
        <div class=\"col-lg-12 text-center v-center\"> 
\t\t\t<form role=\"form\" class=\"col-lg-12\" action=\"";
        // line 12
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("fos_user_security_check");
        echo "\" method=\"post\">
\t\t\t\t<fieldset>
\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t<input type=\"hidden\" name=\"_csrf_token\" value=\"";
        // line 15
        echo twig_escape_filter($this->env, ($context["csrf_token"] ?? $this->getContext($context, "csrf_token")), "html", null, true);
        echo "\" />
\t\t\t\t\t\t<div class=\"input-group input-group-lg col-sm-offset-4 col-sm-4\">
\t\t\t\t\t\t  <span class=\"input-group-addon info\"><span class=\"glyphicon glyphicon-user\" aria-hidden=\"true\"></span></span>
\t\t\t\t\t\t  <input class=\"center-block form-control input-lg\" type=\"text\" id=\"username\" name=\"_username\" value=\"";
        // line 18
        echo twig_escape_filter($this->env, ($context["last_username"] ?? $this->getContext($context, "last_username")), "html", null, true);
        echo "\" required=\"required\" , placeholder=\"Nom d'utilisateur\"/>
\t\t\t\t\t\t</div>   
\t\t\t\t\t</div>
\t\t\t\t\t<!-- Prepended text-->
\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t<div class=\"input-group input-group-lg col-sm-offset-4 col-sm-4\">
\t\t\t\t\t\t  <span class=\"input-group-addon info\"><span class=\"glyphicon glyphicon-lock\" aria-hidden=\"true\"></span></span>
\t\t\t\t\t\t  <input class=\"center-block form-control input-lg\" type=\"password\" id=\"password\" name=\"_password\" required=\"required\" placeholder=\"Mot de passe\"/>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<br><input type=\"checkbox\" id=\"remember_me\" name=\"_remember_me\" value=\"on\" />
\t\t\t\t\t\t<label for=\"remember_me\">";
        // line 28
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("security.login.remember_me", array(), "FOSUserBundle"), "html", null, true);
        echo "</label>   
\t\t\t\t\t\t<br><label for=\"forgot\"><a href=\"";
        // line 29
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("fos_user_resetting_request");
        echo "\">Mot de passe oublié ?</label>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- Button -->
\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t  <label class=\"col-md-4 control-label\" for=\"singlebutton\"></label>
\t\t\t\t\t  <div class=\"col-md-4\">
\t\t\t\t\t\t<button id=\"_submit\" name=\"_submit\" value=\"";
        // line 35
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("security.login.submit", array(), "FOSUserBundle"), "html", null, true);
        echo "\" class=\"btn btn-default btn-lg\">Se connecter</button>
\t\t\t\t\t  </div>
\t\t\t\t\t</div>
\t\t\t\t</fieldset>
\t\t\t</form>
        </div>       
      </div> <!-- /row --> 
  \t
</div> <!-- /container full -->


";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Security:login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  100 => 35,  91 => 29,  87 => 28,  74 => 18,  68 => 15,  62 => 12,  57 => 9,  51 => 7,  49 => 6,  45 => 5,  40 => 4,  34 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"FOSUserBundle::layout.html.twig\" %}

{% block fos_user_content %}
\t<h1 class=\"brand-heading\">{{ societe }}</h1>
\t<p class=\"intro-text\">{{ text }}</p>
{% if error %}
    <div>{{ error|trans({}, 'FOSUserBundle') }}</div>
{% endif %}
<div class=\"container-full\">
      <div class=\"row\">      
        <div class=\"col-lg-12 text-center v-center\"> 
\t\t\t<form role=\"form\" class=\"col-lg-12\" action=\"{{ path(\"fos_user_security_check\") }}\" method=\"post\">
\t\t\t\t<fieldset>
\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t<input type=\"hidden\" name=\"_csrf_token\" value=\"{{ csrf_token }}\" />
\t\t\t\t\t\t<div class=\"input-group input-group-lg col-sm-offset-4 col-sm-4\">
\t\t\t\t\t\t  <span class=\"input-group-addon info\"><span class=\"glyphicon glyphicon-user\" aria-hidden=\"true\"></span></span>
\t\t\t\t\t\t  <input class=\"center-block form-control input-lg\" type=\"text\" id=\"username\" name=\"_username\" value=\"{{ last_username }}\" required=\"required\" , placeholder=\"Nom d'utilisateur\"/>
\t\t\t\t\t\t</div>   
\t\t\t\t\t</div>
\t\t\t\t\t<!-- Prepended text-->
\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t<div class=\"input-group input-group-lg col-sm-offset-4 col-sm-4\">
\t\t\t\t\t\t  <span class=\"input-group-addon info\"><span class=\"glyphicon glyphicon-lock\" aria-hidden=\"true\"></span></span>
\t\t\t\t\t\t  <input class=\"center-block form-control input-lg\" type=\"password\" id=\"password\" name=\"_password\" required=\"required\" placeholder=\"Mot de passe\"/>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<br><input type=\"checkbox\" id=\"remember_me\" name=\"_remember_me\" value=\"on\" />
\t\t\t\t\t\t<label for=\"remember_me\">{{ 'security.login.remember_me'|trans({}, 'FOSUserBundle') }}</label>   
\t\t\t\t\t\t<br><label for=\"forgot\"><a href=\"{{ path('fos_user_resetting_request') }}\">Mot de passe oublié ?</label>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- Button -->
\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t  <label class=\"col-md-4 control-label\" for=\"singlebutton\"></label>
\t\t\t\t\t  <div class=\"col-md-4\">
\t\t\t\t\t\t<button id=\"_submit\" name=\"_submit\" value=\"{{ 'security.login.submit'|trans({}, 'FOSUserBundle') }}\" class=\"btn btn-default btn-lg\">Se connecter</button>
\t\t\t\t\t  </div>
\t\t\t\t\t</div>
\t\t\t\t</fieldset>
\t\t\t</form>
        </div>       
      </div> <!-- /row --> 
  \t
</div> <!-- /container full -->


{% endblock fos_user_content %}
", "FOSUserBundle:Security:login.html.twig", "C:\\wamp\\www\\sar\\src\\Bacloo\\UserBundle/Resources/views/Security/login.html.twig");
    }
}
