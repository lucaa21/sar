<?php

/* FOSUserBundle:Profile:edit_content.html.twig */
class __TwigTemplate_f542b8954139b3c6e61ea6e9370e4bd2a84a83502aafd6deceb44083624da87e extends Twig_Template
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
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Profile:edit_content.html.twig"));

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
        echo "<div class=\"modal-dialog\">
\t<div class=\"modal-content modal-lg\">
\t\t<div class=\"modal-header\">
\t\t\t<span style=\"font-size:25px; font-weight:bold; color:#337ab7\">
\t\t\t\tVotre Profil
\t\t\t</span>
\t\t</div>
\t\t<div class=\"modal-body\">
\t\t\t";
        // line 11
        if (twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "nom", array()), "vars", array()), "value", array()))) {
            // line 12
            echo "\t\t\t\t<div class=\"alert alert-danger\">
\t\t\t\t  <strong>Attention!</strong> Veuillez compléter votre profil afin de commencer à recevoir des leads.<br>* champs obligatoires
\t\t\t\t</div>\t
\t\t\t";
        }
        // line 16
        echo "\t\t\t<form action=\"";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("fos_user_profile_edit");
        echo "\" ";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? $this->getContext($context, "form")), 'enctype');
        echo " method=\"POST\" class=\"fos_user_profile_edit\">
\t\t\t <fieldset> 
\t\t\t";
        // line 18
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? $this->getContext($context, "form")), 'errors');
        echo "\t 
\t\t\t\t";
        // line 20
        echo "\t\t\t\t";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? $this->getContext($context, "form")), 'errors');
        echo "

\t\t\t<div class=\"row clearfix\">

\t\t\t\t<div class=\"form-group\">
\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t  <div class=\"col-md-12\">                   
\t\t\t\t\t\t<br>";
        // line 28
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "tags", array()), 'widget', array("attr" => array("class" => "form-control", "rows" => "5")));
        echo "
\t\t\t\t\t  </div>
\t\t\t\t\t</div>\t\t\t\t 
\t\t\t\t  </div>
\t\t\t\t</div>
\t\t\t\t<br><br><br>
\t\t\t\t<br><br><br>
\t\t\t\t<br><br>
\t\t\t\t<div class=\"form-group\">
\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t  <span class=\"input-group-addon large\">* Départements visés</span>
\t\t\t\t\t  ";
        // line 40
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "cp", array()), 'widget', array("attr" => array("class" => "form-control", "placeholder" => "ex : 92,93,95")));
        echo "
\t\t\t\t\t</div> 
\t\t\t\t\t<p class=\"help-block\">Listez, en les séparant d'une virgule sur 2 chiffres, les codes postaux des régions qui vous intéressent.</p>\t
\t\t\t\t  </div>
\t\t\t\t</div>
\t\t\t</div>

\t\t\t<br>
\t\t\t\t\t\t\t\t\t\t\t
\t\t\t<div class=\"row clearfix col-md-12\">
\t\t\t\t<div class=\"panel panel-default\">
\t\t\t\t\t<div class=\"panel-body\">
\t\t\t\t\t\t<div class=\"col-md-6 column\">\t\t
\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t  <span class=\"input-group-addon large\">* Nom d'utilisateur</span>
\t\t\t\t\t\t\t\t  ";
        // line 57
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "username", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
\t\t\t\t\t\t\t\t</div>    
\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t  ";
        // line 60
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "username", array()), 'errors');
        echo "
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t<div class=\"col-md-6 column\">
\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t  <span class=\"input-group-addon large\">* Adresse email</span>
\t\t\t\t\t\t\t\t  ";
        // line 68
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "email", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
\t\t\t\t\t\t\t\t</div>    
\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t ";
        // line 71
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "email", array()), 'errors');
        echo "
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<br><br>
\t\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t  <span class=\"input-group-addon large\">Mot de passe</span>
\t\t\t\t\t\t\t\t  ";
        // line 80
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "current_password", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
\t\t\t\t\t\t\t\t</div>    
\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t <span style=\"color:red; font-weight:bold;\">Renseignez le mot de passe avant d'enregistrer</span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"panel panel-default\">
\t\t\t\t\t<div class=\"panel-body\">
\t\t\t\t\t\t<div class=\"col-md-12\">
\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t  <span class=\"input-group-addon large\">Nom de votre société</span>
\t\t\t\t\t\t\t\t  ";
        // line 95
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "usernomsociete", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
\t\t\t\t\t\t\t\t <div class=\"hidden\">";
        // line 96
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "usersociete", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "</div>
\t\t\t\t\t\t\t\t</div> 
\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<br><br>
\t\t\t\t\t\t<div class=\"col-md-6 column\">\t\t
\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t  <span class=\"input-group-addon large\">Nom</span>
\t\t\t\t\t\t\t\t  ";
        // line 107
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "nom", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
\t\t\t\t\t\t\t\t</div>    
\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t  ";
        // line 110
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "nom", array()), 'errors');
        echo " 
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t<div class=\"col-md-6 column\">
\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t  <span class=\"input-group-addon large\">Prénom</span>
\t\t\t\t\t\t\t\t  ";
        // line 118
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "prenom", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
\t\t\t\t\t\t\t\t</div>    
\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t  ";
        // line 121
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "prenom", array()), 'errors');
        echo " 
\t\t\t\t\t\t\t</div>\t\t
\t\t\t\t\t\t</div>
\t\t\t\t\t<br><br>

\t\t\t\t\t
\t\t\t\t\t\t<br><br>
\t\t\t\t\t\t<div class=\"col-md-6 column\">\t\t
\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t  <span class=\"input-group-addon large\">CP</span>
\t\t\t\t\t\t\t\t  ";
        // line 133
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "cpuser", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
\t\t\t\t\t\t\t\t</div>    
\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t  ";
        // line 136
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "nom", array()), 'errors');
        echo " 
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t<div class=\"col-md-6 column\">
\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t  <span class=\"input-group-addon large\">Ville</span>
\t\t\t\t\t\t\t\t  ";
        // line 144
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "ville", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
\t\t\t\t\t\t\t\t</div>    
\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t  ";
        // line 147
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "ville", array()), 'errors');
        echo " 
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-6 column\">
\t\t\t\t
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-6 column\">
\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t  <span class=\"input-group-addon large\">Activité</span>
\t\t\t\t\t\t  ";
        // line 160
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "activite", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
\t\t\t\t\t\t</div>    
\t\t\t\t\t  </div>
\t\t\t\t\t ";
        // line 163
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "prenom", array()), 'errors');
        echo "  
\t\t\t\t\t</div>\t\t
\t\t\t\t</div>
\t\t\t<br><br><br>
\t\t\t</div>\t
\t\t\t";
        // line 168
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "_token", array()), 'row');
        echo "\t
\t\t\t<div>
\t\t\t\t<input type=\"submit\" class=\"btn btn-primary\" value=\"";
        // line 170
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("profile.edit.submit", array(), "FOSUserBundle"), "html", null, true);
        echo "\" />
\t\t\t</div>
\t\t </fieldset>
\t\t</form>\t
\t</div>
</div>

";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Profile:edit_content.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  282 => 170,  277 => 168,  269 => 163,  263 => 160,  247 => 147,  241 => 144,  230 => 136,  224 => 133,  209 => 121,  203 => 118,  192 => 110,  186 => 107,  172 => 96,  168 => 95,  150 => 80,  138 => 71,  132 => 68,  121 => 60,  115 => 57,  95 => 40,  80 => 28,  68 => 20,  64 => 18,  56 => 16,  50 => 12,  48 => 11,  38 => 3,  26 => 2,  23 => 1,);
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
<div class=\"modal-dialog\">
\t<div class=\"modal-content modal-lg\">
\t\t<div class=\"modal-header\">
\t\t\t<span style=\"font-size:25px; font-weight:bold; color:#337ab7\">
\t\t\t\tVotre Profil
\t\t\t</span>
\t\t</div>
\t\t<div class=\"modal-body\">
\t\t\t{% if form.nom.vars.value is empty %}
\t\t\t\t<div class=\"alert alert-danger\">
\t\t\t\t  <strong>Attention!</strong> Veuillez compléter votre profil afin de commencer à recevoir des leads.<br>* champs obligatoires
\t\t\t\t</div>\t
\t\t\t{% endif %}
\t\t\t<form action=\"{{ path('fos_user_profile_edit') }}\" {{ form_enctype(form) }} method=\"POST\" class=\"fos_user_profile_edit\">
\t\t\t <fieldset> 
\t\t\t{{ form_errors(form) }}\t 
\t\t\t\t{# Les erreurs générales du formulaire. #}
\t\t\t\t{{ form_errors(form) }}

\t\t\t<div class=\"row clearfix\">

\t\t\t\t<div class=\"form-group\">
\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t  <div class=\"col-md-12\">                   
\t\t\t\t\t\t<br>{{ form_widget(form.tags, { 'attr' : { 'class' : 'form-control' ,'rows' : '5'} })  }}
\t\t\t\t\t  </div>
\t\t\t\t\t</div>\t\t\t\t 
\t\t\t\t  </div>
\t\t\t\t</div>
\t\t\t\t<br><br><br>
\t\t\t\t<br><br><br>
\t\t\t\t<br><br>
\t\t\t\t<div class=\"form-group\">
\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t  <span class=\"input-group-addon large\">* Départements visés</span>
\t\t\t\t\t  {{ form_widget(form.cp, { 'attr' : { 'class' : 'form-control', 'placeholder' : 'ex : 92,93,95'}})  }}
\t\t\t\t\t</div> 
\t\t\t\t\t<p class=\"help-block\">Listez, en les séparant d'une virgule sur 2 chiffres, les codes postaux des régions qui vous intéressent.</p>\t
\t\t\t\t  </div>
\t\t\t\t</div>
\t\t\t</div>

\t\t\t<br>
\t\t\t\t\t\t\t\t\t\t\t
\t\t\t<div class=\"row clearfix col-md-12\">
\t\t\t\t<div class=\"panel panel-default\">
\t\t\t\t\t<div class=\"panel-body\">
\t\t\t\t\t\t<div class=\"col-md-6 column\">\t\t
\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t  <span class=\"input-group-addon large\">* Nom d'utilisateur</span>
\t\t\t\t\t\t\t\t  {{ form_widget(form.username, { 'attr' : { 'class' : 'form-control' } })  }}
\t\t\t\t\t\t\t\t</div>    
\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t  {{ form_errors(form.username) }}
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t<div class=\"col-md-6 column\">
\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t  <span class=\"input-group-addon large\">* Adresse email</span>
\t\t\t\t\t\t\t\t  {{ form_widget(form.email, { 'attr' : { 'class' : 'form-control' } })  }}
\t\t\t\t\t\t\t\t</div>    
\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t {{ form_errors(form.email) }}
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<br><br>
\t\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t  <span class=\"input-group-addon large\">Mot de passe</span>
\t\t\t\t\t\t\t\t  {{ form_widget(form.current_password, { 'attr' : { 'class' : 'form-control' } })  }}
\t\t\t\t\t\t\t\t</div>    
\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t <span style=\"color:red; font-weight:bold;\">Renseignez le mot de passe avant d'enregistrer</span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"panel panel-default\">
\t\t\t\t\t<div class=\"panel-body\">
\t\t\t\t\t\t<div class=\"col-md-12\">
\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t  <span class=\"input-group-addon large\">Nom de votre société</span>
\t\t\t\t\t\t\t\t  {{ form_widget(form.usernomsociete, { 'attr' : { 'class' : 'form-control' } })  }}
\t\t\t\t\t\t\t\t <div class=\"hidden\">{{ form_widget(form.usersociete, { 'attr' : { 'class' : 'form-control' } })  }}</div>
\t\t\t\t\t\t\t\t</div> 
\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<br><br>
\t\t\t\t\t\t<div class=\"col-md-6 column\">\t\t
\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t  <span class=\"input-group-addon large\">Nom</span>
\t\t\t\t\t\t\t\t  {{ form_widget(form.nom, { 'attr' : { 'class' : 'form-control' } })  }}
\t\t\t\t\t\t\t\t</div>    
\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t  {{ form_errors(form.nom) }} 
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t<div class=\"col-md-6 column\">
\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t  <span class=\"input-group-addon large\">Prénom</span>
\t\t\t\t\t\t\t\t  {{ form_widget(form.prenom, { 'attr' : { 'class' : 'form-control' } })  }}
\t\t\t\t\t\t\t\t</div>    
\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t  {{ form_errors(form.prenom) }} 
\t\t\t\t\t\t\t</div>\t\t
\t\t\t\t\t\t</div>
\t\t\t\t\t<br><br>

\t\t\t\t\t
\t\t\t\t\t\t<br><br>
\t\t\t\t\t\t<div class=\"col-md-6 column\">\t\t
\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t  <span class=\"input-group-addon large\">CP</span>
\t\t\t\t\t\t\t\t  {{ form_widget(form.cpuser, { 'attr' : { 'class' : 'form-control' } })  }}
\t\t\t\t\t\t\t\t</div>    
\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t  {{ form_errors(form.nom) }} 
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t<div class=\"col-md-6 column\">
\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t  <span class=\"input-group-addon large\">Ville</span>
\t\t\t\t\t\t\t\t  {{ form_widget(form.ville, { 'attr' : { 'class' : 'form-control' } })  }}
\t\t\t\t\t\t\t\t</div>    
\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t  {{ form_errors(form.ville) }} 
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-6 column\">
\t\t\t\t
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-6 column\">
\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t  <div class=\"col-md-12\">
\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t  <span class=\"input-group-addon large\">Activité</span>
\t\t\t\t\t\t  {{ form_widget(form.activite, { 'attr' : { 'class' : 'form-control' } })  }}
\t\t\t\t\t\t</div>    
\t\t\t\t\t  </div>
\t\t\t\t\t {{ form_errors(form.prenom) }}  
\t\t\t\t\t</div>\t\t
\t\t\t\t</div>
\t\t\t<br><br><br>
\t\t\t</div>\t
\t\t\t{{ form_row(form._token) }}\t
\t\t\t<div>
\t\t\t\t<input type=\"submit\" class=\"btn btn-primary\" value=\"{{ 'profile.edit.submit'|trans({}, 'FOSUserBundle') }}\" />
\t\t\t</div>
\t\t </fieldset>
\t\t</form>\t
\t</div>
</div>

{% endblock %}", "FOSUserBundle:Profile:edit_content.html.twig", "C:\\wamp\\www\\sar\\src\\Bacloo\\UserBundle/Resources/views/Profile/edit_content.html.twig");
    }
}
