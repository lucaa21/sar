<?php

/* BaclooCrmBundle:Crm:agence.html.twig */
class __TwigTemplate_df1ed24d28053e63863d6e24f7ff14ac2e7e525a7964400a71bd47628ab9d25a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 3
        $this->parent = $this->loadTemplate("BaclooCrmBundle::layout.html.twig", "BaclooCrmBundle:Crm:agence.html.twig", 3);
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
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "BaclooCrmBundle:Crm:agence.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 4
    public function block_body($context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 5
        echo "\t<div class=\"row clearfix\">
\t\t<div class=\"col-md-12\">
                <ul class=\"nav nav-tabs\">
                ";
        // line 8
        if ((($context["onglet"] ?? $this->getContext($context, "onglet")) == "missions")) {
            // line 9
            echo "                    <li class=\"active\"><a href=\"#tab1default\" data-toggle=\"tab\"><h5>Missions</h5></a></li>
                    <li><a href=\"#tab2default\" data-toggle=\"tab\"><h5>Profils</h5></a></li>
                    <li><a href=\"#tab3default\" data-toggle=\"tab\"><h5>Candidatures</h5></a></li>
                ";
        } elseif ((        // line 12
($context["onglet"] ?? $this->getContext($context, "onglet")) == "profils")) {
            // line 13
            echo "                    <li><a href=\"#tab1default\" data-toggle=\"tab\"><h5>Missions</h5></a></li>
                    <li class=\"active\"><a href=\"#tab2default\" data-toggle=\"tab\"><h5>Profils</h5></a></li>
                    <li><a href=\"#tab3default\" data-toggle=\"tab\"><h5>Candidatures</h5></a></li>    
                ";
        } else {
            // line 16
            echo "  
                    <li><a href=\"#tab1default\" data-toggle=\"tab\"><h5>Missions</h5></a></li>
                    <li><a href=\"#tab2default\" data-toggle=\"tab\"><h5>Profils</h5></a></li>
                    <li class=\"active\"><a href=\"#tab3default\" data-toggle=\"tab\"><h5>Candidatures</h5></a></li>    
                ";
        }
        // line 20
        echo " 
                </ul>
                <div class=\"tab-content\">
                ";
        // line 23
        if ((($context["onglet"] ?? $this->getContext($context, "onglet")) == "missions")) {
            // line 24
            echo "                    <div class=\"tab-pane fade in active\" id=\"tab1default\">  
                ";
        } else {
            // line 26
            echo "                    <div class=\"tab-pane fade\" id=\"tab1default\">  
                ";
        }
        // line 28
        echo "                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Nouvelle mission
                                </h3>
                            </div>
                            ";
        // line 35
        echo "                            <div class=\"panel-body\">   
                                <form class=\"form-horizontal\" action=\"";
        // line 36
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("bacloocrm_agence");
        echo "\" method=\"post\" ";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? $this->getContext($context, "form")), 'enctype');
        echo ">
                                    <fieldset>
                                        <div class=\"col-md-6 column\">
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Titre</span>
                                                            ";
        // line 43
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "titre", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Date début</span>
                                                            ";
        // line 51
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "datedebut", array()), 'widget', array("attr" => array("class" => "form-control datepicker")));
        echo "
                                                            ";
        // line 53
        echo "                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Date fin</span>
                                                            ";
        // line 60
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "datefin", array()), 'widget', array("attr" => array("class" => "form-control datepicker")));
        echo "
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Adresse</span>
                                                            ";
        // line 68
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "adresse", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Dresscode</span>
                                                            ";
        // line 76
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "dresscode", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
                                                        </div>    
                                                    </div>
                                                </div>
                                        </div>
                                        <div class=\"col-md-6 column\">
                                            <div class=\"form-group\">
                                                <div class=\"col-md-12\">
                                                    <div class=\"input-group\">
                                                        <span class=\"input-group-addon large\">Raison sociale</span>
                                                        ";
        // line 86
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "raisonsociale", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
                                                    </div>    
                                                </div>
                                            </div>
                                            <div class=\"form-group\">
                                                <div class=\"col-md-12\">
                                                    <div class=\"input-group\">
                                                        <span class=\"input-group-addon large\">Description</span>
                                                        ";
        // line 94
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "description", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
                                                    </div>    
                                                </div>
                                            </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Code postal</span>
                                                            ";
        // line 102
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "codepostal", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Ville</span>
                                                            ";
        // line 110
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "ville", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Urgent (0/1)</span>
                                                            ";
        // line 118
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "urgent", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
                                                        </div>    
                                                    </div>
                                                </div>
                                        </div>                        
                                        <input type=\"submit\" class=\"btn btn-primary\" value=\"Enregistrer\"/>
                                    ";
        // line 124
        echo "\t\t
                                ";
        // line 125
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "_token", array()), 'row');
        echo "\t
                                </fieldset>
                                </form>
                            ";
        // line 129
        echo "                            </div>
                        </div> 

                            ";
        // line 132
        echo "                        
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Liste des missions
                                </h3>
                            </div>
                            <div class=\"panel-body\"> 
                            ";
        // line 140
        $context["compteur"] = 0;
        // line 141
        echo "                            <table>
                            ";
        // line 142
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["missions1"] ?? $this->getContext($context, "missions1")));
        foreach ($context['_seq'] as $context["_key"] => $context["mission"]) {
            // line 143
            echo "                                ";
            $context["compteur"] = (($context["compteur"] ?? $this->getContext($context, "compteur")) + 1);
            // line 144
            echo "                                ";
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 1)) {
                // line 145
                echo "                                <tr><td width=\"528\">                    
                                ";
            } else {
                // line 147
                echo "                                <td width=\"528\">
                                ";
            }
            // line 148
            echo "                          
                                <div class=\"panel panel-default\">
                                    <div style=\"height:270px\"class=\"panel-body\">
                                    <table cellpadding=\"4\" style=\"font-size:18px;\">
                                            <tr>
                                                <td colspan=\"3\"> 
                                                    <center><h3><b>";
            // line 154
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "titre", array()), "html", null, true);
            echo "</b></h3></center>                                                                                  
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 159
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datedebut", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 163
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "adresse", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 168
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datefin", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 172
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "codepostal", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>    
                                            <tr>
                                                <td>
                                                    ";
            // line 177
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "description", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 181
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "ville", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>          
                                            <tr>
                                                <td>
                                                    ";
            // line 186
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "dresscode", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 190
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "raisonsociale", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr> 
                                            <tr>
                                            <center><span>Urgent</span></center>
                                            </tr>                             
                                    </table>
                                    </div>   
                                    <center><span class=\"pull-left\">";
            // line 198
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "nbaccepte", array()), "html", null, true);
            echo " ";
            if (($this->getAttribute($context["mission"], "nbaccepte", array()) > 1)) {
                echo " employés sur cette mission";
            } else {
                echo " employé sur cette mission";
            }
            // line 199
            echo "                                    ";
            // line 208
            echo "                                    </span></center>
                                    <span class=\"pull-right\"><a type=\"button\" class=\"btn btn-danger\" 
                                    href=\"";
            // line 210
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("bacloocrm_removemission", array("id" => $this->getAttribute($context["mission"], "id", array()))), "html", null, true);
            echo "\">Supprimer</span></a></span>                                    
                                    </div>
                                </div>
                                ";
            // line 213
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 3)) {
                // line 214
                echo "                                </td>
                                </tr> 
                                ";
                // line 216
                $context["compteur"] = 1;
                echo "  
                                
                                ";
            } else {
                // line 219
                echo "                                </td>
                                    ";
                // line 220
                if (((($context["compteur"] ?? $this->getContext($context, "compteur")) == 1) || (($context["compteur"] ?? $this->getContext($context, "compteur")) == 2))) {
                    // line 221
                    echo "                                    <td width=\"15\">
                                    </td>
                                    ";
                }
                // line 224
                echo "                                ";
            }
            // line 225
            echo "                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['mission'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 226
        echo "                            </table>
                            <br><br>
      
                            ";
        // line 229
        $context["compteur"] = 0;
        // line 230
        echo "                            <table>
                            ";
        // line 231
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["missions0"] ?? $this->getContext($context, "missions0")));
        foreach ($context['_seq'] as $context["_key"] => $context["mission"]) {
            // line 232
            echo "                                ";
            $context["compteur"] = (($context["compteur"] ?? $this->getContext($context, "compteur")) + 1);
            // line 233
            echo "                                ";
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 1)) {
                // line 234
                echo "                                <tr><td width=\"528\">                     
                                ";
            } else {
                // line 236
                echo "                                <td width=\"528\">
                                ";
            }
            // line 237
            echo "                          
                                <div class=\"panel panel-default\">
                                    <div style=\"height:270px\"class=\"panel-body\">
                                    <table cellpadding=\"4\" style=\"font-size:18px;\">
                                            <tr>
                                                <td colspan=\"3\"> 
                                                    <center><h3><b>";
            // line 243
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "titre", array()), "html", null, true);
            echo "</b></h3></center>                                                                                  
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 248
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datedebut", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 252
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "adresse", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 257
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datefin", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 261
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "codepostal", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>    
                                            <tr>
                                                <td>
                                                    ";
            // line 266
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "description", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 270
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "ville", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>          
                                            <tr>
                                                <td>
                                                    ";
            // line 275
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "dresscode", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 279
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "raisonsociale", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>                            
                                    </table>
                                    </div>   
                                    <center><span class=\"pull-left\">";
            // line 284
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "nbaccepte", array()), "html", null, true);
            echo " ";
            if (($this->getAttribute($context["mission"], "nbaccepte", array()) > 1)) {
                echo " employés sur cette mission";
            } else {
                echo " employé sur cette mission";
            }
            // line 285
            echo "                                    ";
            // line 294
            echo "                                    </span></center>
                                    <span class=\"pull-right\"><a type=\"button\" class=\"btn btn-danger\" 
                                    href=\"";
            // line 296
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("bacloocrm_removemission", array("id" => $this->getAttribute($context["mission"], "id", array()))), "html", null, true);
            echo "\">Supprimer</span></a></span>                                    
                                    </div>
                                </div>
                                ";
            // line 299
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 3)) {
                // line 300
                echo "                                </td>
                                </tr> 
                                ";
                // line 302
                $context["compteur"] = 1;
                echo "  
                                
                                ";
            } else {
                // line 305
                echo "                                </td>
                                    ";
                // line 306
                if (((($context["compteur"] ?? $this->getContext($context, "compteur")) == 1) || (($context["compteur"] ?? $this->getContext($context, "compteur")) == 2))) {
                    // line 307
                    echo "                                    <td width=\"15\">
                                    </td>
                                    ";
                }
                // line 310
                echo "                                ";
            }
            // line 311
            echo "                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['mission'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 312
        echo "                            </table>
                            </div>
                        </div>
                            ";
        // line 316
        echo "                    </div>
                ";
        // line 317
        if ((($context["onglet"] ?? $this->getContext($context, "onglet")) == "profils")) {
            // line 318
            echo "                    <div class=\"tab-pane fade in active\" id=\"tab2default\">
                ";
        } else {
            // line 320
            echo "                    <div class=\"tab-pane fade\" id=\"tab2default\">  
                ";
        }
        // line 322
        echo "                    ";
        echo "                        
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Liste des profils des employés
                                </h3>
                            </div>
\t\t\t\t\t\t\t\t\t\t
                            <div class=\"panel-body\"> 
                            ";
        // line 332
        echo "                            <div class=\"panel-body\">   
                                <form class=\"form-horizontal\" action=\"";
        // line 333
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("bacloocrm_agence", array("onglet" => "profils"));
        echo "\" method=\"post\" ";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form2"] ?? $this->getContext($context, "form2")), 'enctype');
        echo ">
                                    <fieldset>
                                        <div class=\"col-md-3 column\">
                                            <div class=\"form-group\">
                                                <div class=\"col-md-12\">
                                                    <div class=\"input-group\">
                                                        <span class=\"input-group-addon large\">Nom</span>
                                                        ";
        // line 340
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form2"] ?? $this->getContext($context, "form2")), "nom", array()), 'widget', array("attr" => array("class" => "form-control")));
        echo "
                                                    </div>    
                                                </div>
                                            </div>
                                        </div>                        
                                        <input type=\"submit\" class=\"btn btn-primary\" value=\"Rechercher\"/>
                                        <a type=\"button\" class=\"btn btn-info\" href=\"";
        // line 346
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("bacloocrm_agence", array("onglet" => "profils", "nom" => 0)), "html", null, true);
        echo "\">Réinitialiser</span></a>
                                    ";
        // line 347
        echo "\t\t
                                ";
        // line 348
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form2"] ?? $this->getContext($context, "form2")), "_token", array()), 'row');
        echo "\t
                                </fieldset>
                                </form>
                            </div>
                            ";
        // line 353
        echo "                            ";
        $context["compteur"] = 0;
        // line 354
        echo "                            <table>
                            ";
        // line 355
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["users"] ?? $this->getContext($context, "users")));
        foreach ($context['_seq'] as $context["_key"] => $context["user"]) {
            // line 356
            echo "                                ";
            if (($this->getAttribute($context["user"], "roleuser", array()) == "employe")) {
                // line 357
                echo "                                    ";
                $context["compteur"] = (($context["compteur"] ?? $this->getContext($context, "compteur")) + 1);
                // line 358
                echo "                                    ";
                if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 6)) {
                    // line 359
                    echo "                                    <tr>                              
                                    ";
                } else {
                    // line 361
                    echo "                                    <td width=\"235\">
                                    ";
                }
                // line 362
                echo "                               
                                    <div class=\"panel panel-default\">
                                        <div style=\"height:400px\" class=\"panel-body\">
                                        <table cellpadding=\"4\" style=\"font-size:18px;\" border=\"0\">
                                                <tr>
                                                    <td colspan=\"3\"> 
                                                        <center><h3><b>";
                // line 368
                echo twig_escape_filter($this->env, $this->getAttribute($context["user"], "prenom", array()), "html", null, true);
                echo " ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["user"], "nom", array()), "html", null, true);
                echo "</b></h3></center>                                                                                  
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        ";
                // line 373
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context["user"], "datenaissance", array()), "d/m/Y"), "html", null, true);
                echo "
                                                    </td>
                                                    <td style=\"width:15px\"></td>
                                                    <td>
                                                        ";
                // line 377
                echo twig_escape_filter($this->env, $this->getAttribute($context["user"], "adresse", array()), "html", null, true);
                echo "
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        ";
                // line 382
                echo twig_escape_filter($this->env, $this->getAttribute($context["user"], "email", array()), "html", null, true);
                echo "
                                                    </td>
                                                    <td style=\"width:15px\"></td>
                                                    <td>
                                                        ";
                // line 386
                echo twig_escape_filter($this->env, $this->getAttribute($context["user"], "tel", array()), "html", null, true);
                echo "
                                                    </td>
                                                </tr> 
                                                <tr>
                                                    ";
                // line 390
                $context["count"] = 0;
                echo "        
                                                    ";
                // line 391
                $context["nomDoc"] = "";
                echo "        

                                                    ";
                // line 393
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["documents"] ?? $this->getContext($context, "documents")));
                foreach ($context['_seq'] as $context["_key"] => $context["document"]) {
                    // line 394
                    echo "                                                         ";
                    if (($this->getAttribute($context["document"], "codedocument", array()) == $this->getAttribute($context["user"], "id", array()))) {
                        // line 395
                        echo "                                                            ";
                        $context["count"] = 1;
                        // line 396
                        echo "                                                            ";
                        $context["nomDoc"] = $this->getAttribute($context["document"], "nom", array());
                        // line 397
                        echo "                                                        ";
                    }
                    // line 398
                    echo "                                                    ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['document'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 399
                echo "
                                                    ";
                // line 400
                if ((($context["count"] ?? $this->getContext($context, "count")) == 1)) {
                    echo " 
                                                        <td>
                                                            <img width=\"200\" src=\"";
                    // line 402
                    echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl((((("uploads/employe/" . $this->getAttribute($context["user"], "id", array())) . "/") . ($context["nomDoc"] ?? $this->getContext($context, "nomDoc"))) . "")), "html", null, true);
                    echo "\">
                                                        </td>
                                                    ";
                } else {
                    // line 405
                    echo "                                                        <td>
                                                            Pas de photo de profil
                                                        </td>
                                                    ";
                }
                // line 408
                echo "  

                                                </tr>                            
                                        </table>
                                        </div>
                                        ";
                // line 415
                echo "                                    
                                    ";
                // line 416
                if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 6)) {
                    // line 417
                    echo "                                    </tr>
                                    
                                    ";
                } else {
                    // line 420
                    echo "                                    </td>
                                        ";
                    // line 421
                    if ((((((($context["compteur"] ?? $this->getContext($context, "compteur")) == 1) || (($context["compteur"] ?? $this->getContext($context, "compteur")) == 2)) || (($context["compteur"] ?? $this->getContext($context, "compteur")) == 3)) || (($context["compteur"] ?? $this->getContext($context, "compteur")) == 4)) || (($context["compteur"] ?? $this->getContext($context, "compteur")) == 5))) {
                        // line 422
                        echo "                                        <td width=\"15\">
                                        </td>
                                        ";
                    }
                    // line 425
                    echo "                                    ";
                }
                // line 426
                echo "                                ";
            }
            // line 427
            echo "                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['user'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 428
        echo "                            </table>
                            <br><br>
                            </div>
                        </div>
                        ";
        // line 433
        echo "                    </div>
                ";
        // line 434
        if (( !(($context["onglet"] ?? $this->getContext($context, "onglet")) === "missions") &&  !(($context["onglet"] ?? $this->getContext($context, "onglet")) === "profils"))) {
            // line 435
            echo "                    <div class=\"tab-pane fade in active\" id=\"tab3default\">
                ";
        } else {
            // line 437
            echo "                    <div class=\"tab-pane fade\" id=\"tab3default\">  
                ";
        }
        // line 439
        echo "                    ";
        echo "                        
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Candidatures
                                </h3>
                            </div>
                            <div class=\"panel-body\"> 
                            ";
        // line 447
        $context["compteur"] = 0;
        // line 448
        echo "                            <table>
                            ";
        // line 449
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["missionpostule2"] ?? $this->getContext($context, "missionpostule2")));
        foreach ($context['_seq'] as $context["_key"] => $context["mission"]) {
            // line 450
            echo "                                ";
            $context["compteur"] = (($context["compteur"] ?? $this->getContext($context, "compteur")) + 1);
            // line 451
            echo "                                ";
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 6)) {
                // line 452
                echo "                                <tr>                              
                                ";
            } else {
                // line 454
                echo "                                <td width=\"528\">
                                ";
            }
            // line 455
            echo "                               
                                <div class=\"panel panel-default\">
                                    <div style=\"height:270px\"class=\"panel-body\">
                                    <table cellpadding=\"4\" style=\"font-size:18px;\">
                                            <tr>
                                                <td colspan=\"3\"> 
                                                    <center><h3><b>";
            // line 461
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "titre", array()), "html", null, true);
            echo "</b></h3></center>                                                                                  
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 466
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datedebut", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 470
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "adresse", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 475
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datefin", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 479
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "codepostal", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>    
                                            <tr>
                                                <td>
                                                    ";
            // line 484
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "description", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 488
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "ville", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>          
                                            <tr>
                                                <td>
                                                    ";
            // line 493
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "dresscode", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 497
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "raisonsociale", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr> 

                                            ";
            // line 501
            $context["nom"] = "";
            // line 502
            echo "                                            ";
            $context["prenom"] = "";
            // line 503
            echo "
                                            ";
            // line 504
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["users"] ?? $this->getContext($context, "users")));
            foreach ($context['_seq'] as $context["_key"] => $context["user"]) {
                // line 505
                echo "                                                ";
                if (($this->getAttribute($context["mission"], "profilid", array()) == $this->getAttribute($context["user"], "id", array()))) {
                    // line 506
                    echo "                                                    ";
                    $context["nom"] = $this->getAttribute($context["user"], "nom", array());
                    // line 507
                    echo "                                                    ";
                    $context["prenom"] = $this->getAttribute($context["user"], "prenom", array());
                    echo "                                               
                                                ";
                }
                // line 509
                echo "                                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['user'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 510
            echo "                                            <tr>
                                                <td colspan=\"3\"> 
                                                    <center><h3><b>Candidature de ";
            // line 512
            echo twig_escape_filter($this->env, ($context["prenom"] ?? $this->getContext($context, "prenom")), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, ($context["nom"] ?? $this->getContext($context, "nom")), "html", null, true);
            echo "</b></h3></center>                                                                                  
                                                </td>
                                            </tr>                             
                                    </table>
                                    </div>
                                    ";
            // line 517
            if (($this->getAttribute($context["mission"], "accepte", array()) == 1)) {
                // line 518
                echo "                                        <center><span>Accepté</span></center>
                                    ";
            } elseif (($this->getAttribute(            // line 519
$context["mission"], "refuse", array()) == 1)) {
                // line 520
                echo "                                        <center><span>Refusé</span></center>
                                    ";
            } else {
                // line 522
                echo "                                        <span class=\"pull-left\"><a type=\"button\" class=\"btn btn-success\" 
                                        href=\"";
                // line 523
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("bacloocrm_acceptercandidature", array("id" => $this->getAttribute($context["mission"], "id", array()))), "html", null, true);
                echo "\">Accepter</span></a></span>
                                        <span class=\"pull-right\"><a type=\"button\" class=\"btn btn-danger\" 
                                        href=\"";
                // line 525
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("bacloocrm_refusercandidature", array("id" => $this->getAttribute($context["mission"], "id", array()))), "html", null, true);
                echo "\">Refuser</span></a></span>                                          
                                    ";
            }
            // line 527
            echo "                                </div>
                                ";
            // line 528
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 4)) {
                // line 529
                echo "                                </tr>
                                
                                ";
            } else {
                // line 532
                echo "                                </td>
                                    ";
                // line 533
                if (((($context["compteur"] ?? $this->getContext($context, "compteur")) == 1) || (($context["compteur"] ?? $this->getContext($context, "compteur")) == 2))) {
                    // line 534
                    echo "                                    <td width=\"15\">
                                    </td>
                                    ";
                }
                // line 537
                echo "                                ";
            }
            // line 538
            echo "                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['mission'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 539
        echo "                            </table>
                            <br><br>
                            </div>
                        </div>
                    ";
        // line 544
        echo "                    </div>
                </div>
        </div>
\t\t<div class=\"col-md-12\">
        </div>
    </div>

<script>
  \$( function() {
\t\$( \".datepicker\" ).datepicker({
\t\tdateFormat: 'dd/mm/yy', 
\t\tfirstDay:1\t\t\t
\t});
  } );
</script>

";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "BaclooCrmBundle:Crm:agence.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1012 => 544,  1006 => 539,  1000 => 538,  997 => 537,  992 => 534,  990 => 533,  987 => 532,  982 => 529,  980 => 528,  977 => 527,  972 => 525,  967 => 523,  964 => 522,  960 => 520,  958 => 519,  955 => 518,  953 => 517,  943 => 512,  939 => 510,  933 => 509,  927 => 507,  924 => 506,  921 => 505,  917 => 504,  914 => 503,  911 => 502,  909 => 501,  902 => 497,  895 => 493,  887 => 488,  880 => 484,  872 => 479,  865 => 475,  857 => 470,  850 => 466,  842 => 461,  834 => 455,  830 => 454,  826 => 452,  823 => 451,  820 => 450,  816 => 449,  813 => 448,  811 => 447,  800 => 439,  796 => 437,  792 => 435,  790 => 434,  787 => 433,  781 => 428,  775 => 427,  772 => 426,  769 => 425,  764 => 422,  762 => 421,  759 => 420,  754 => 417,  752 => 416,  749 => 415,  742 => 408,  736 => 405,  730 => 402,  725 => 400,  722 => 399,  716 => 398,  713 => 397,  710 => 396,  707 => 395,  704 => 394,  700 => 393,  695 => 391,  691 => 390,  684 => 386,  677 => 382,  669 => 377,  662 => 373,  652 => 368,  644 => 362,  640 => 361,  636 => 359,  633 => 358,  630 => 357,  627 => 356,  623 => 355,  620 => 354,  617 => 353,  610 => 348,  607 => 347,  603 => 346,  594 => 340,  582 => 333,  579 => 332,  567 => 322,  563 => 320,  559 => 318,  557 => 317,  554 => 316,  549 => 312,  543 => 311,  540 => 310,  535 => 307,  533 => 306,  530 => 305,  524 => 302,  520 => 300,  518 => 299,  512 => 296,  508 => 294,  506 => 285,  498 => 284,  490 => 279,  483 => 275,  475 => 270,  468 => 266,  460 => 261,  453 => 257,  445 => 252,  438 => 248,  430 => 243,  422 => 237,  418 => 236,  414 => 234,  411 => 233,  408 => 232,  404 => 231,  401 => 230,  399 => 229,  394 => 226,  388 => 225,  385 => 224,  380 => 221,  378 => 220,  375 => 219,  369 => 216,  365 => 214,  363 => 213,  357 => 210,  353 => 208,  351 => 199,  343 => 198,  332 => 190,  325 => 186,  317 => 181,  310 => 177,  302 => 172,  295 => 168,  287 => 163,  280 => 159,  272 => 154,  264 => 148,  260 => 147,  256 => 145,  253 => 144,  250 => 143,  246 => 142,  243 => 141,  241 => 140,  231 => 132,  226 => 129,  220 => 125,  217 => 124,  208 => 118,  197 => 110,  186 => 102,  175 => 94,  164 => 86,  151 => 76,  140 => 68,  129 => 60,  120 => 53,  116 => 51,  105 => 43,  93 => 36,  90 => 35,  82 => 28,  78 => 26,  74 => 24,  72 => 23,  67 => 20,  60 => 16,  54 => 13,  52 => 12,  47 => 9,  45 => 8,  40 => 5,  34 => 4,  11 => 3,);
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
{# src/Bacloo/CrmBundle/Resources/views/Blog/search.html.twig #}
{% extends \"BaclooCrmBundle::layout.html.twig\" %}
{% block body %}
\t<div class=\"row clearfix\">
\t\t<div class=\"col-md-12\">
                <ul class=\"nav nav-tabs\">
                {% if onglet == 'missions' %}
                    <li class=\"active\"><a href=\"#tab1default\" data-toggle=\"tab\"><h5>Missions</h5></a></li>
                    <li><a href=\"#tab2default\" data-toggle=\"tab\"><h5>Profils</h5></a></li>
                    <li><a href=\"#tab3default\" data-toggle=\"tab\"><h5>Candidatures</h5></a></li>
                {% elseif onglet == 'profils' %}
                    <li><a href=\"#tab1default\" data-toggle=\"tab\"><h5>Missions</h5></a></li>
                    <li class=\"active\"><a href=\"#tab2default\" data-toggle=\"tab\"><h5>Profils</h5></a></li>
                    <li><a href=\"#tab3default\" data-toggle=\"tab\"><h5>Candidatures</h5></a></li>    
                {% else %}  
                    <li><a href=\"#tab1default\" data-toggle=\"tab\"><h5>Missions</h5></a></li>
                    <li><a href=\"#tab2default\" data-toggle=\"tab\"><h5>Profils</h5></a></li>
                    <li class=\"active\"><a href=\"#tab3default\" data-toggle=\"tab\"><h5>Candidatures</h5></a></li>    
                {% endif %} 
                </ul>
                <div class=\"tab-content\">
                {% if onglet == 'missions' %}
                    <div class=\"tab-pane fade in active\" id=\"tab1default\">  
                {% else %}
                    <div class=\"tab-pane fade\" id=\"tab1default\">  
                {% endif %}
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Nouvelle mission
                                </h3>
                            </div>
                            {#Formulaire saisie mission#}
                            <div class=\"panel-body\">   
                                <form class=\"form-horizontal\" action=\"{{ path('bacloocrm_agence') }}\" method=\"post\" {{form_enctype(form) }}>
                                    <fieldset>
                                        <div class=\"col-md-6 column\">
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Titre</span>
                                                            {{ form_widget(form.titre, { 'attr' : { 'class' : 'form-control' } })  }}
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Date début</span>
                                                            {{ form_widget(form.datedebut, { 'attr' : { 'class' : 'form-control datepicker' } })  }}
                                                            {# {{ form_widget(form.datenaissance, {'value': userdetails.datenaissance|date('d/m/Y'), 'attr' : { 'class' : 'form-control datepicker', 'placeholder' : 'Date de naissance' } })  }} #}
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Date fin</span>
                                                            {{ form_widget(form.datefin, { 'attr' : { 'class' : 'form-control datepicker' } })  }}
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Adresse</span>
                                                            {{ form_widget(form.adresse, { 'attr' : { 'class' : 'form-control' } })  }}
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Dresscode</span>
                                                            {{ form_widget(form.dresscode, { 'attr' : { 'class' : 'form-control' } })  }}
                                                        </div>    
                                                    </div>
                                                </div>
                                        </div>
                                        <div class=\"col-md-6 column\">
                                            <div class=\"form-group\">
                                                <div class=\"col-md-12\">
                                                    <div class=\"input-group\">
                                                        <span class=\"input-group-addon large\">Raison sociale</span>
                                                        {{ form_widget(form.raisonsociale, { 'attr' : { 'class' : 'form-control' } })  }}
                                                    </div>    
                                                </div>
                                            </div>
                                            <div class=\"form-group\">
                                                <div class=\"col-md-12\">
                                                    <div class=\"input-group\">
                                                        <span class=\"input-group-addon large\">Description</span>
                                                        {{ form_widget(form.description, { 'attr' : { 'class' : 'form-control' } })  }}
                                                    </div>    
                                                </div>
                                            </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Code postal</span>
                                                            {{ form_widget(form.codepostal, { 'attr' : { 'class' : 'form-control' } })  }}
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Ville</span>
                                                            {{ form_widget(form.ville, { 'attr' : { 'class' : 'form-control' } })  }}
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class=\"form-group\">
                                                    <div class=\"col-md-12\">
                                                        <div class=\"input-group\">
                                                            <span class=\"input-group-addon large\">Urgent (0/1)</span>
                                                            {{ form_widget(form.urgent, { 'attr' : { 'class' : 'form-control' } })  }}
                                                        </div>    
                                                    </div>
                                                </div>
                                        </div>                        
                                        <input type=\"submit\" class=\"btn btn-primary\" value=\"Enregistrer\"/>
                                    {#</div>#}\t\t
                                {{ form_row(form._token) }}\t
                                </fieldset>
                                </form>
                            {#Fin formulaire saisie mission#}
                            </div>
                        </div> 

                            {#Affichage mission#}                        
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Liste des missions
                                </h3>
                            </div>
                            <div class=\"panel-body\"> 
                            {% set compteur = 0 %}
                            <table>
                            {% for mission in missions1 %}
                                {% set compteur = compteur +1 %}
                                {% if compteur == 1 %}
                                <tr><td width=\"528\">                    
                                {% else %}
                                <td width=\"528\">
                                {% endif %}                          
                                <div class=\"panel panel-default\">
                                    <div style=\"height:270px\"class=\"panel-body\">
                                    <table cellpadding=\"4\" style=\"font-size:18px;\">
                                            <tr>
                                                <td colspan=\"3\"> 
                                                    <center><h3><b>{{mission.titre}}</b></h3></center>                                                                                  
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{mission.datedebut}}
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    {{mission.adresse}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{mission.datefin}}
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    {{mission.codepostal}}
                                                </td>
                                            </tr>    
                                            <tr>
                                                <td>
                                                    {{mission.description}}
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    {{mission.ville}}
                                                </td>
                                            </tr>          
                                            <tr>
                                                <td>
                                                    {{mission.dresscode}}
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    {{mission.raisonsociale}}
                                                </td>
                                            </tr> 
                                            <tr>
                                            <center><span>Urgent</span></center>
                                            </tr>                             
                                    </table>
                                    </div>   
                                    <center><span class=\"pull-left\">{{ mission.nbaccepte }} {% if mission.nbaccepte > 1 %} employés sur cette mission{% else %} employé sur cette mission{% endif %}
                                    {#({% for missionp in missionpostule %}
                                    {% if missionp.missionid == mission.id %}
                                    {% for user in users %}
                                    {% if user.id == missionp.profilid %}
                                        <a href=\"{{ path('bacloocrm_agence', {'onglet': 'profils', 'nom': user.nom }) }}\">{{ user.nom }} {{ user.prenom }}</a>
                                    {% endif %}
                                    {% endfor %}
                                    {% endif %}
                                    {% endfor %})#}
                                    </span></center>
                                    <span class=\"pull-right\"><a type=\"button\" class=\"btn btn-danger\" 
                                    href=\"{{ path('bacloocrm_removemission', {'id': mission.id}) }}\">Supprimer</span></a></span>                                    
                                    </div>
                                </div>
                                {% if compteur == 3 %}
                                </td>
                                </tr> 
                                {% set compteur = 1 %}  
                                
                                {% else %}
                                </td>
                                    {% if compteur == 1 or compteur == 2 %}
                                    <td width=\"15\">
                                    </td>
                                    {% endif %}
                                {% endif %}
                            {% endfor %}
                            </table>
                            <br><br>
      
                            {% set compteur = 0 %}
                            <table>
                            {% for mission in missions0 %}
                                {% set compteur = compteur +1 %}
                                {% if compteur == 1 %}
                                <tr><td width=\"528\">                     
                                {% else %}
                                <td width=\"528\">
                                {% endif %}                          
                                <div class=\"panel panel-default\">
                                    <div style=\"height:270px\"class=\"panel-body\">
                                    <table cellpadding=\"4\" style=\"font-size:18px;\">
                                            <tr>
                                                <td colspan=\"3\"> 
                                                    <center><h3><b>{{mission.titre}}</b></h3></center>                                                                                  
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{mission.datedebut}}
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    {{mission.adresse}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{mission.datefin}}
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    {{mission.codepostal}}
                                                </td>
                                            </tr>    
                                            <tr>
                                                <td>
                                                    {{mission.description}}
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    {{mission.ville}}
                                                </td>
                                            </tr>          
                                            <tr>
                                                <td>
                                                    {{mission.dresscode}}
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    {{mission.raisonsociale}}
                                                </td>
                                            </tr>                            
                                    </table>
                                    </div>   
                                    <center><span class=\"pull-left\">{{ mission.nbaccepte }} {% if mission.nbaccepte > 1 %} employés sur cette mission{% else %} employé sur cette mission{% endif %}
                                    {#({% for missionp in missionpostule %}
                                    {% if missionp.missionid == mission.id %}
                                    {% for user in users %}
                                    {% if user.id == missionp.profilid %}
                                        <a href=\"{{ path('bacloocrm_agence', {'onglet': 'profils', 'nom': user.nom }) }}\">{{ user.nom }} {{ user.prenom }}</a>
                                    {% endif %}
                                    {% endfor %}
                                    {% endif %}
                                    {% endfor %})#}
                                    </span></center>
                                    <span class=\"pull-right\"><a type=\"button\" class=\"btn btn-danger\" 
                                    href=\"{{ path('bacloocrm_removemission', {'id': mission.id}) }}\">Supprimer</span></a></span>                                    
                                    </div>
                                </div>
                                {% if compteur == 3 %}
                                </td>
                                </tr> 
                                {% set compteur = 1 %}  
                                
                                {% else %}
                                </td>
                                    {% if compteur == 1 or compteur == 2 %}
                                    <td width=\"15\">
                                    </td>
                                    {% endif %}
                                {% endif %}
                            {% endfor %}
                            </table>
                            </div>
                        </div>
                            {#Fin affichage mission#}
                    </div>
                {% if onglet == 'profils' %}
                    <div class=\"tab-pane fade in active\" id=\"tab2default\">
                {% else %}
                    <div class=\"tab-pane fade\" id=\"tab2default\">  
                {% endif %}
                    {#Affichage PROFILS#}                        
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Liste des profils des employés
                                </h3>
                            </div>
\t\t\t\t\t\t\t\t\t\t
                            <div class=\"panel-body\"> 
                            {#Formulaire recherche profil #}
                            <div class=\"panel-body\">   
                                <form class=\"form-horizontal\" action=\"{{ path('bacloocrm_agence', {'onglet': 'profils'}) }}\" method=\"post\" {{form_enctype(form2) }}>
                                    <fieldset>
                                        <div class=\"col-md-3 column\">
                                            <div class=\"form-group\">
                                                <div class=\"col-md-12\">
                                                    <div class=\"input-group\">
                                                        <span class=\"input-group-addon large\">Nom</span>
                                                        {{ form_widget(form2.nom, { 'attr' : { 'class' : 'form-control' } })  }}
                                                    </div>    
                                                </div>
                                            </div>
                                        </div>                        
                                        <input type=\"submit\" class=\"btn btn-primary\" value=\"Rechercher\"/>
                                        <a type=\"button\" class=\"btn btn-info\" href=\"{{ path('bacloocrm_agence', {'onglet': 'profils', 'nom': 0}) }}\">Réinitialiser</span></a>
                                    {#</div>#}\t\t
                                {{ form_row(form2._token) }}\t
                                </fieldset>
                                </form>
                            </div>
                            {#Fin recherche profil #}
                            {% set compteur = 0 %}
                            <table>
                            {% for user in users %}
                                {% if user.roleuser == 'employe' %}
                                    {% set compteur = compteur +1 %}
                                    {% if compteur == 6 %}
                                    <tr>                              
                                    {% else %}
                                    <td width=\"235\">
                                    {% endif %}                               
                                    <div class=\"panel panel-default\">
                                        <div style=\"height:400px\" class=\"panel-body\">
                                        <table cellpadding=\"4\" style=\"font-size:18px;\" border=\"0\">
                                                <tr>
                                                    <td colspan=\"3\"> 
                                                        <center><h3><b>{{user.prenom}} {{user.nom}}</b></h3></center>                                                                                  
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        {{user.datenaissance|date('d/m/Y')}}
                                                    </td>
                                                    <td style=\"width:15px\"></td>
                                                    <td>
                                                        {{user.adresse}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        {{user.email}}
                                                    </td>
                                                    <td style=\"width:15px\"></td>
                                                    <td>
                                                        {{user.tel}}
                                                    </td>
                                                </tr> 
                                                <tr>
                                                    {% set count = 0 %}        
                                                    {% set nomDoc = \"\" %}        

                                                    {% for document in documents %}
                                                         {% if document.codedocument == user.id %}
                                                            {% set count = 1 %}
                                                            {% set nomDoc = document.nom %}
                                                        {% endif %}
                                                    {% endfor %}

                                                    {% if count == 1 %} 
                                                        <td>
                                                            <img width=\"200\" src=\"{{ asset('uploads/employe/'~ user.id ~'/' ~ nomDoc ~ '') }}\">
                                                        </td>
                                                    {% else %}
                                                        <td>
                                                            Pas de photo de profil
                                                        </td>
                                                    {% endif %}  

                                                </tr>                            
                                        </table>
                                        </div>
                                        {#<span class=\"pull-right\"><a type=\"button\" class=\"btn btn-danger\" 
                                        href=\"{{ path('bacloocrm_removemission', {'id': .id}) }}\">Supprimer</span></a></span></div>#}
                                    
                                    {% if compteur == 6 %}
                                    </tr>
                                    
                                    {% else %}
                                    </td>
                                        {% if compteur == 1 or compteur == 2 or compteur == 3  or compteur == 4  or compteur == 5 %}
                                        <td width=\"15\">
                                        </td>
                                        {% endif %}
                                    {% endif %}
                                {% endif %}
                            {% endfor %}
                            </table>
                            <br><br>
                            </div>
                        </div>
                        {#Fin affichage PROFILS#}
                    </div>
                {% if onglet is not  same as('missions') and onglet is not same as ('profils') %}
                    <div class=\"tab-pane fade in active\" id=\"tab3default\">
                {% else %}
                    <div class=\"tab-pane fade\" id=\"tab3default\">  
                {% endif %}
                    {# Affichage candidatures missions #}                        
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Candidatures
                                </h3>
                            </div>
                            <div class=\"panel-body\"> 
                            {% set compteur = 0 %}
                            <table>
                            {% for mission in missionpostule2 %}
                                {% set compteur = compteur +1 %}
                                {% if compteur == 6 %}
                                <tr>                              
                                {% else %}
                                <td width=\"528\">
                                {% endif %}                               
                                <div class=\"panel panel-default\">
                                    <div style=\"height:270px\"class=\"panel-body\">
                                    <table cellpadding=\"4\" style=\"font-size:18px;\">
                                            <tr>
                                                <td colspan=\"3\"> 
                                                    <center><h3><b>{{mission.titre}}</b></h3></center>                                                                                  
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{mission.datedebut}}
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    {{mission.adresse}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{mission.datefin}}
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    {{mission.codepostal}}
                                                </td>
                                            </tr>    
                                            <tr>
                                                <td>
                                                    {{mission.description}}
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    {{mission.ville}}
                                                </td>
                                            </tr>          
                                            <tr>
                                                <td>
                                                    {{mission.dresscode}}
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    {{mission.raisonsociale}}
                                                </td>
                                            </tr> 

                                            {% set nom = '' %}
                                            {% set prenom = '' %}

                                            {% for user in users %}
                                                {% if mission.profilid == user.id %}
                                                    {% set nom = user.nom %}
                                                    {% set prenom = user.prenom %}                                               
                                                {% endif %}
                                            {% endfor %}
                                            <tr>
                                                <td colspan=\"3\"> 
                                                    <center><h3><b>Candidature de {{prenom}} {{nom}}</b></h3></center>                                                                                  
                                                </td>
                                            </tr>                             
                                    </table>
                                    </div>
                                    {% if mission.accepte == 1 %}
                                        <center><span>Accepté</span></center>
                                    {% elseif mission.refuse == 1 %}
                                        <center><span>Refusé</span></center>
                                    {% else %}
                                        <span class=\"pull-left\"><a type=\"button\" class=\"btn btn-success\" 
                                        href=\"{{ path('bacloocrm_acceptercandidature', {'id': mission.id}) }}\">Accepter</span></a></span>
                                        <span class=\"pull-right\"><a type=\"button\" class=\"btn btn-danger\" 
                                        href=\"{{ path('bacloocrm_refusercandidature', {'id': mission.id}) }}\">Refuser</span></a></span>                                          
                                    {% endif %}
                                </div>
                                {% if compteur == 4 %}
                                </tr>
                                
                                {% else %}
                                </td>
                                    {% if compteur == 1 or compteur == 2 %}
                                    <td width=\"15\">
                                    </td>
                                    {% endif %}
                                {% endif %}
                            {% endfor %}
                            </table>
                            <br><br>
                            </div>
                        </div>
                    {# Fin affichage candidatures missions #}
                    </div>
                </div>
        </div>
\t\t<div class=\"col-md-12\">
        </div>
    </div>

<script>
  \$( function() {
\t\$( \".datepicker\" ).datepicker({
\t\tdateFormat: 'dd/mm/yy', 
\t\tfirstDay:1\t\t\t
\t});
  } );
</script>

{% endblock %}

", "BaclooCrmBundle:Crm:agence.html.twig", "C:\\wamp\\www\\sar\\src\\Bacloo\\CrmBundle/Resources/views/Crm/agence.html.twig");
    }
}
