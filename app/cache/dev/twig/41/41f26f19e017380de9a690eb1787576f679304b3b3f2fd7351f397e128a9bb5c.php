<?php

/* BaclooCrmBundle:Crm:employe.html.twig */
class __TwigTemplate_a6ab39d15344980c7cf599553309e470b6e57cdfe7f7d536dc7613f62ba9d8e0 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 3
        $this->parent = $this->loadTemplate("BaclooCrmBundle::layout.html.twig", "BaclooCrmBundle:Crm:employe.html.twig", 3);
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
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "BaclooCrmBundle:Crm:employe.html.twig"));

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
                    <li class=\"active\"><a href=\"#tab1default\" data-toggle=\"tab\"><h5>Profil</h5></a></li>
                    <li><a href=\"#tab2default\" data-toggle=\"tab\"><h5>Missions</h5></a></li>
                    <li><a href=\"#tab3default\" data-toggle=\"tab\"><h5>A venir</h5></a></li>
                </ul>
                <div class=\"tab-content\">
                    <div class=\"tab-pane fade\" id=\"tab2default\">
                            ";
        // line 14
        echo "                        
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Liste des missions à postuler
                                </h3>
                            </div>
                            <div class=\"panel-body\"> 
                            ";
        // line 22
        $context["compteur"] = 0;
        // line 23
        echo "                            <table>
                            ";
        // line 24
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["missions1"] ?? $this->getContext($context, "missions1")));
        foreach ($context['_seq'] as $context["_key"] => $context["mission"]) {
            // line 25
            echo "                                ";
            $context["compteur"] = (($context["compteur"] ?? $this->getContext($context, "compteur")) + 1);
            // line 26
            echo "                                ";
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 1)) {
                // line 27
                echo "                                <tr><td width=\"528\">                    
                                ";
            } else {
                // line 29
                echo "                                <td width=\"528\">
                                ";
            }
            // line 30
            echo "                          
                                <div class=\"panel panel-default\">
                                    <div style=\"height:270px\"class=\"panel-body\">
                                    <table cellpadding=\"4\" style=\"font-size:18px;\">
                                            <tr>
                                                <td colspan=\"3\"> 
                                                    <center><h3><b>";
            // line 36
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "titre", array()), "html", null, true);
            echo "</b></h3></center>                                                                                  
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 41
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datedebut", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 45
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "adresse", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 50
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datefin", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 54
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "codepostal", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>    
                                            <tr>
                                                <td>
                                                    ";
            // line 59
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "description", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 63
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "ville", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>          
                                            <tr>
                                                <td>
                                                    ";
            // line 68
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "dresscode", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 72
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "raisonsociale", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>                             
                                    </table>
                                    </div>
                                    ";
            // line 77
            $context["compteur1"] = 0;
            // line 78
            echo "                                    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["missionpostule"] ?? $this->getContext($context, "missionpostule")));
            foreach ($context['_seq'] as $context["_key"] => $context["missions"]) {
                // line 79
                echo "                                        ";
                if ((($this->getAttribute($context["missions"], "missionid", array()) == $this->getAttribute($context["mission"], "id", array())) && ($this->getAttribute($context["missions"], "postule", array()) == 1))) {
                    // line 80
                    echo "                                            ";
                    $context["compteur1"] = 1;
                    // line 81
                    echo "                                        ";
                }
                // line 82
                echo "                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['missions'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 83
            echo "                                    ";
            if ((($context["compteur1"] ?? $this->getContext($context, "compteur1")) == 0)) {
                // line 84
                echo "                                            <center><span><a type=\"button\" class=\"btn btn-success\" 
                                            href=\"";
                // line 85
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("bacloocrm_postulermission", array("id" => $this->getAttribute($context["mission"], "id", array()))), "html", null, true);
                echo "\">Postuler</span></a></span></center>
                                    ";
            } else {
                // line 87
                echo "                                            <center><span>Déjà postulé</span></center>
                                    ";
            }
            // line 89
            echo "                                </div>
                                ";
            // line 90
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 3)) {
                // line 91
                echo "                                </td>
                                </tr> 
                                ";
                // line 93
                $context["compteur"] = 1;
                echo "  
                                
                                ";
            } else {
                // line 96
                echo "                                </td>
                                    ";
                // line 97
                if (((($context["compteur"] ?? $this->getContext($context, "compteur")) == 1) || (($context["compteur"] ?? $this->getContext($context, "compteur")) == 2))) {
                    // line 98
                    echo "                                    <td width=\"15\">
                                    </td>
                                    ";
                }
                // line 101
                echo "                                ";
            }
            // line 102
            echo "                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['mission'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 103
        echo "                            </table>
                            <br><br>
                            ";
        // line 105
        $context["compteur"] = 0;
        // line 106
        echo "                            <table>
                            ";
        // line 107
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["missions0"] ?? $this->getContext($context, "missions0")));
        foreach ($context['_seq'] as $context["_key"] => $context["mission"]) {
            // line 108
            echo "                                ";
            $context["compteur"] = (($context["compteur"] ?? $this->getContext($context, "compteur")) + 1);
            // line 109
            echo "                                ";
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 6)) {
                // line 110
                echo "                                <tr>                              
                                ";
            } else {
                // line 112
                echo "                                <td width=\"528\">
                                ";
            }
            // line 113
            echo "                               
                                <div class=\"panel panel-default\">
                                    <div style=\"height:270px\"class=\"panel-body\">
                                    <table cellpadding=\"4\" style=\"font-size:18px;\">
                                            <tr>
                                                <td colspan=\"3\"> 
                                                    <center><h3><b>";
            // line 119
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "titre", array()), "html", null, true);
            echo "</b></h3></center>                                                                                  
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 124
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datedebut", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 128
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "adresse", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 133
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datefin", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 137
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "codepostal", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>    
                                            <tr>
                                                <td>
                                                    ";
            // line 142
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "description", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 146
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "ville", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>          
                                            <tr>
                                                <td>
                                                    ";
            // line 151
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "dresscode", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 155
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "raisonsociale", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>                              
                                    </table>
                                    </div>
                                    ";
            // line 160
            $context["compteur1"] = 0;
            // line 161
            echo "                                    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["missionpostule"] ?? $this->getContext($context, "missionpostule")));
            foreach ($context['_seq'] as $context["_key"] => $context["missions"]) {
                // line 162
                echo "                                        ";
                if ((($this->getAttribute($context["missions"], "missionid", array()) == $this->getAttribute($context["mission"], "id", array())) && ($this->getAttribute($context["missions"], "postule", array()) == 1))) {
                    // line 163
                    echo "                                            ";
                    $context["compteur1"] = 1;
                    // line 164
                    echo "                                        ";
                }
                // line 165
                echo "                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['missions'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 166
            echo "                                    ";
            if ((($context["compteur1"] ?? $this->getContext($context, "compteur1")) == 0)) {
                // line 167
                echo "                                            <center><span><a type=\"button\" class=\"btn btn-success\" 
                                            href=\"";
                // line 168
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("bacloocrm_postulermission", array("id" => $this->getAttribute($context["mission"], "id", array()))), "html", null, true);
                echo "\">Postuler</span></a></span></center>
                                    ";
            } else {
                // line 170
                echo "                                            <center><span>Déjà postulé</span></center>
                                    ";
            }
            // line 172
            echo "                                </div>
                                ";
            // line 173
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 4)) {
                // line 174
                echo "                                </tr>
                                
                                ";
            } else {
                // line 177
                echo "                                </td>
                                    ";
                // line 178
                if (((($context["compteur"] ?? $this->getContext($context, "compteur")) == 1) || (($context["compteur"] ?? $this->getContext($context, "compteur")) == 2))) {
                    // line 179
                    echo "                                    <td width=\"15\">
                                    </td>
                                    ";
                }
                // line 182
                echo "                                ";
            }
            // line 183
            echo "                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['mission'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 184
        echo "                            </table>
                            </div>
                        </div>
                            ";
        // line 188
        echo "                    </div>

                    <div class=\"tab-pane fade in active\" id=\"tab1default\">
                        ";
        // line 191
        echo "                        
                        <div class=\"panel panel-default\">
                            <div class=\"panel-body\">
                                <form class=\"form-horizontal\" action=\"";
        // line 194
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("bacloocrm_employe");
        echo "\"  method=\"post\" ";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? $this->getContext($context, "form")), 'enctype');
        echo ">
                                    <div class=\"form-group\">
                                        <div class=\"col-md-6\">
                                            <div class=\"input-group\">
                                                ";
        // line 198
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "nom", array()), 'widget', array("value" => $this->getAttribute(($context["userdetails"] ?? $this->getContext($context, "userdetails")), "nom", array()), "attr" => array("class" => "form-control", "placeholder" => "Nom")));
        echo "
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"form-group\">
                                        <div class=\"col-md-6\">
                                            <div class=\"input-group\">
                                                ";
        // line 205
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "prenom", array()), 'widget', array("value" => $this->getAttribute(($context["userdetails"] ?? $this->getContext($context, "userdetails")), "prenom", array()), "attr" => array("class" => "form-control adresse2", "placeholder" => "Prénom")));
        echo "
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"form-group\">
                                        <div class=\"col-md-6\">
                                            <div class=\"input-group\">
                                                ";
        // line 212
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "datenaissance", array()), 'widget', array("value" => twig_date_format_filter($this->env, $this->getAttribute(($context["userdetails"] ?? $this->getContext($context, "userdetails")), "datenaissance", array()), "d/m/Y"), "attr" => array("class" => "form-control datepicker", "placeholder" => "Date de naissance")));
        echo "
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"form-group\">
                                        <div class=\"col-md-6\">
                                            <div class=\"input-group\">
                                                ";
        // line 219
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "email", array()), 'widget', array("value" => $this->getAttribute(($context["userdetails"] ?? $this->getContext($context, "userdetails")), "email", array()), "attr" => array("class" => "form-control", "placeholder" => "email")));
        echo "
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"form-group\">
                                        <div class=\"col-md-6\">
                                            <div class=\"input-group\">
                                                ";
        // line 226
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "rib", array()), 'widget', array("value" => $this->getAttribute(($context["userdetails"] ?? $this->getContext($context, "userdetails")), "rib", array()), "attr" => array("class" => "form-control", "placeholder" => "RIB")));
        echo "
                                            </div>
                                        </div>
                                    </div>
                                    ";
        // line 230
        if (twig_test_empty(($context["documents"] ?? $this->getContext($context, "documents")))) {
            // line 231
            echo "                                        ";
            // line 232
            echo "                                        <div class=\"row clearfix\">
                                            <div class=\"col-sm-12\">
                                                <center><div class=\"dropzone col-md-6\" id=\"my-awesome-dropzone\" style=\"border-style: dashed solid; height:80px; width:200px;\"><div class=\"dz-message\" data-dz-message><span>Cliquez ou glissez votre photo ici</span></div></div></center>
                                            </div>
                                        </div>
                                    ";
        } else {
            // line 238
            echo "                                        <div class=\"row clearfix\">
                                            <div class=\"col-md-12\">
                                                <table>
                                                    <tr>
                                                        ";
            // line 242
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["documents"] ?? $this->getContext($context, "documents")));
            foreach ($context['_seq'] as $context["_key"] => $context["document"]) {
                // line 243
                echo "                                                            <td>
                                                                <img width=\"200\" src=\"";
                // line 244
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl((((("uploads/employe/" . $this->getAttribute(($context["userdetails"] ?? $this->getContext($context, "userdetails")), "id", array())) . "/") . $this->getAttribute($context["document"], "nom", array())) . "")), "html", null, true);
                echo "\">
                                                            </td>
                                                            <td class=\"col-md-10 pull-right\">
                                                                <a href=\"";
                // line 247
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("bacloocrm_removedocument", array("iddoc" => $this->getAttribute($context["document"], "id", array()), "codedocument" => $this->getAttribute(($context["userdetails"] ?? $this->getContext($context, "userdetails")), "id", array()), "type" => "employe")), "html", null, true);
                echo "\"><i class=\"fa fa-times\"></i></a>
                                                            </td>
                                                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['document'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 250
            echo "                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    ";
        }
        // line 255
        echo "                                    <br>
                                    <button type=\"submit\" class=\"btn btn-info\">
                                        Enregistrer
                                    </button>
                                </form>
                            </div>
                        </div>
                        ";
        // line 263
        echo "
                        ";
        // line 264
        echo " 
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Liste de vos missions passées
                                </h3>
                            </div>
                            <div class=\"panel-body\"> 
                            ";
        // line 272
        $context["compteur"] = 0;
        // line 273
        echo "                            <table>
                            ";
        // line 274
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["missionpasse"] ?? $this->getContext($context, "missionpasse")));
        foreach ($context['_seq'] as $context["_key"] => $context["mission"]) {
            // line 275
            echo "                                ";
            $context["compteur"] = (($context["compteur"] ?? $this->getContext($context, "compteur")) + 1);
            // line 276
            echo "                                ";
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 1)) {
                // line 277
                echo "                                <tr><td width=\"528\">                    
                                ";
            } else {
                // line 279
                echo "                                <td width=\"528\">
                                ";
            }
            // line 280
            echo "                          
                                <div class=\"panel panel-default\">
                                    <div style=\"height:270px\"class=\"panel-body\">
                                    <table cellpadding=\"4\" style=\"font-size:18px;\">
                                            <tr>
                                                <td colspan=\"3\"> 
                                                    <center><h3><b>";
            // line 286
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "titre", array()), "html", null, true);
            echo "</b></h3></center>                                                                                  
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 291
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datedebut", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 295
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "adresse", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 300
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datefin", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 304
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "codepostal", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>    
                                            <tr>
                                                <td>
                                                    ";
            // line 309
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "description", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 313
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "ville", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>          
                                            <tr>
                                                <td>
                                                    ";
            // line 318
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "dresscode", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 322
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "raisonsociale", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>                             
                                    </table>
                                    </div>
                                    <center><span>Mission terminée</span></center>
                                </div>
                                ";
            // line 329
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 3)) {
                // line 330
                echo "                                </td>
                                </tr> 
                                ";
                // line 332
                $context["compteur"] = 1;
                echo "  
                                
                                ";
            } else {
                // line 335
                echo "                                </td>
                                    ";
                // line 336
                if (((($context["compteur"] ?? $this->getContext($context, "compteur")) == 1) || (($context["compteur"] ?? $this->getContext($context, "compteur")) == 2))) {
                    // line 337
                    echo "                                    <td width=\"15\">
                                    </td>
                                    ";
                }
                // line 340
                echo "                                ";
            }
            // line 341
            echo "                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['mission'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 342
        echo "                            </table>
                            <br><br>
                            </div>
                        </div>                      
                        ";
        // line 346
        echo "   
                    </div>

                    <div class=\"tab-pane fade\" id=\"tab3default\">
                    ";
        // line 350
        echo " 
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Missions du jour
                                </h3>
                            </div>
                            <div class=\"panel-body\"> 
                            ";
        // line 358
        $context["compteur"] = 0;
        // line 359
        echo "                            <table>
                            ";
        // line 360
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["missionjour"] ?? $this->getContext($context, "missionjour")));
        foreach ($context['_seq'] as $context["_key"] => $context["mission"]) {
            // line 361
            echo "                                ";
            $context["compteur"] = (($context["compteur"] ?? $this->getContext($context, "compteur")) + 1);
            // line 362
            echo "                                ";
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 1)) {
                // line 363
                echo "                                <tr><td width=\"528\">                    
                                ";
            } else {
                // line 365
                echo "                                <td width=\"528\">
                                ";
            }
            // line 366
            echo "                          
                                <div class=\"panel panel-default\">
                                    <div style=\"height:270px\"class=\"panel-body\">
                                    <table cellpadding=\"4\" style=\"font-size:18px;\">
                                            <tr>
                                                <td colspan=\"3\"> 
                                                    <center><h3><b>";
            // line 372
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "titre", array()), "html", null, true);
            echo "</b></h3></center>                                                                                  
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 377
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datedebut", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 381
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "adresse", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 386
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datefin", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 390
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "codepostal", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>    
                                            <tr>
                                                <td>
                                                    ";
            // line 395
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "description", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 399
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "ville", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>          
                                            <tr>
                                                <td>
                                                    ";
            // line 404
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "dresscode", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 408
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "raisonsociale", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr> 
                                            <tr>                            
                                    </table>
                                    </div>
                                    <center><span>Mission à venir</span></center>
                                </div>
                                ";
            // line 416
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 3)) {
                // line 417
                echo "                                </td>
                                </tr> 
                                ";
                // line 419
                $context["compteur"] = 1;
                echo "  
                                
                                ";
            } else {
                // line 422
                echo "                                </td>
                                    ";
                // line 423
                if (((($context["compteur"] ?? $this->getContext($context, "compteur")) == 1) || (($context["compteur"] ?? $this->getContext($context, "compteur")) == 2))) {
                    // line 424
                    echo "                                    <td width=\"15\">
                                    </td>
                                    ";
                }
                // line 427
                echo "                                ";
            }
            // line 428
            echo "                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['mission'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 429
        echo "                            </table>
                            <br><br>
                            </div>
                        </div>
                    ";
        // line 434
        echo "                    ";
        // line 435
        echo "                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Liste des missions à venir
                                </h3>
                            </div>
                            <div class=\"panel-body\"> 
                            ";
        // line 442
        $context["compteur"] = 0;
        // line 443
        echo "                            <table>
                            ";
        // line 444
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["missionfutur"] ?? $this->getContext($context, "missionfutur")));
        foreach ($context['_seq'] as $context["_key"] => $context["mission"]) {
            // line 445
            echo "                                ";
            $context["compteur"] = (($context["compteur"] ?? $this->getContext($context, "compteur")) + 1);
            // line 446
            echo "                                ";
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 1)) {
                // line 447
                echo "                                <tr><td width=\"528\">                    
                                ";
            } else {
                // line 449
                echo "                                <td width=\"528\">
                                ";
            }
            // line 450
            echo "                          
                                <div class=\"panel panel-default\">
                                    <div style=\"height:270px\"class=\"panel-body\">
                                    <table cellpadding=\"4\" style=\"font-size:18px;\">
                                            <tr>
                                                <td colspan=\"3\"> 
                                                    <center><h3><b>";
            // line 456
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "titre", array()), "html", null, true);
            echo "</b></h3></center>                                                                                  
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 461
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datedebut", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 465
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "adresse", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    ";
            // line 470
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "datefin", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 474
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "codepostal", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>    
                                            <tr>
                                                <td>
                                                    ";
            // line 479
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "description", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 483
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "ville", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr>          
                                            <tr>
                                                <td>
                                                    ";
            // line 488
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "dresscode", array()), "html", null, true);
            echo "
                                                </td>
                                                <td style=\"width:15px\"></td>
                                                <td>
                                                    ";
            // line 492
            echo twig_escape_filter($this->env, $this->getAttribute($context["mission"], "raisonsociale", array()), "html", null, true);
            echo "
                                                </td>
                                            </tr> 
                                            <tr>                             
                                    </table>
                                    </div>
                                    <center><span>Mission à venir</span></center>
                                </div>
                                ";
            // line 500
            if ((($context["compteur"] ?? $this->getContext($context, "compteur")) == 3)) {
                // line 501
                echo "                                </td>
                                </tr> 
                                ";
                // line 503
                $context["compteur"] = 1;
                echo "  
                                
                                ";
            } else {
                // line 506
                echo "                                </td>
                                    ";
                // line 507
                if (((($context["compteur"] ?? $this->getContext($context, "compteur")) == 1) || (($context["compteur"] ?? $this->getContext($context, "compteur")) == 2))) {
                    // line 508
                    echo "                                    <td width=\"15\">
                                    </td>
                                    ";
                }
                // line 511
                echo "                                ";
            }
            // line 512
            echo "                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['mission'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 513
        echo "                            </table>
                            <br><br>
                            </div>
                        </div>
                    ";
        // line 518
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
</script>\t

<script>
    // init,configure dropzone
    Dropzone.autoDiscover = true;
    var dropzone_default = new Dropzone(\".dropzone\", {
        url: '";
        // line 539
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("bacloocrm_dropzone", array("codedocument" => $this->getAttribute(($context["userdetails"] ?? $this->getContext($context, "userdetails")), "id", array()), "type" => "employe")), "html", null, true);
        echo "',
        maxFiles: 1,
        dictMaxFilesExceeded: 'Only 1 Image can be uploaded',

        acceptedFiles: '.jpg, .jpeg, .png, .bmp, .pdf',
        maxFilesize: 3,  // in Mb
        addRemoveLinks: true,
        init: function () {
            this.on(\"maxfilesexceeded\", function(file) {
                this.removeFile(file);
            });
            this.on(\"sending\", function(file, xhr, formData) {
                // send additional data with the file as POST data if needed.
                // formData.append(\"key\", \"value\");  
            });
            this.on(\"success\", function() {
                if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                        location.reload();
                }
            });
        }
    });
</script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "BaclooCrmBundle:Crm:employe.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1006 => 539,  983 => 518,  977 => 513,  971 => 512,  968 => 511,  963 => 508,  961 => 507,  958 => 506,  952 => 503,  948 => 501,  946 => 500,  935 => 492,  928 => 488,  920 => 483,  913 => 479,  905 => 474,  898 => 470,  890 => 465,  883 => 461,  875 => 456,  867 => 450,  863 => 449,  859 => 447,  856 => 446,  853 => 445,  849 => 444,  846 => 443,  844 => 442,  835 => 435,  833 => 434,  827 => 429,  821 => 428,  818 => 427,  813 => 424,  811 => 423,  808 => 422,  802 => 419,  798 => 417,  796 => 416,  785 => 408,  778 => 404,  770 => 399,  763 => 395,  755 => 390,  748 => 386,  740 => 381,  733 => 377,  725 => 372,  717 => 366,  713 => 365,  709 => 363,  706 => 362,  703 => 361,  699 => 360,  696 => 359,  694 => 358,  684 => 350,  678 => 346,  672 => 342,  666 => 341,  663 => 340,  658 => 337,  656 => 336,  653 => 335,  647 => 332,  643 => 330,  641 => 329,  631 => 322,  624 => 318,  616 => 313,  609 => 309,  601 => 304,  594 => 300,  586 => 295,  579 => 291,  571 => 286,  563 => 280,  559 => 279,  555 => 277,  552 => 276,  549 => 275,  545 => 274,  542 => 273,  540 => 272,  530 => 264,  527 => 263,  518 => 255,  511 => 250,  502 => 247,  496 => 244,  493 => 243,  489 => 242,  483 => 238,  475 => 232,  473 => 231,  471 => 230,  464 => 226,  454 => 219,  444 => 212,  434 => 205,  424 => 198,  415 => 194,  410 => 191,  405 => 188,  400 => 184,  394 => 183,  391 => 182,  386 => 179,  384 => 178,  381 => 177,  376 => 174,  374 => 173,  371 => 172,  367 => 170,  362 => 168,  359 => 167,  356 => 166,  350 => 165,  347 => 164,  344 => 163,  341 => 162,  336 => 161,  334 => 160,  326 => 155,  319 => 151,  311 => 146,  304 => 142,  296 => 137,  289 => 133,  281 => 128,  274 => 124,  266 => 119,  258 => 113,  254 => 112,  250 => 110,  247 => 109,  244 => 108,  240 => 107,  237 => 106,  235 => 105,  231 => 103,  225 => 102,  222 => 101,  217 => 98,  215 => 97,  212 => 96,  206 => 93,  202 => 91,  200 => 90,  197 => 89,  193 => 87,  188 => 85,  185 => 84,  182 => 83,  176 => 82,  173 => 81,  170 => 80,  167 => 79,  162 => 78,  160 => 77,  152 => 72,  145 => 68,  137 => 63,  130 => 59,  122 => 54,  115 => 50,  107 => 45,  100 => 41,  92 => 36,  84 => 30,  80 => 29,  76 => 27,  73 => 26,  70 => 25,  66 => 24,  63 => 23,  61 => 22,  51 => 14,  40 => 5,  34 => 4,  11 => 3,);
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
                    <li class=\"active\"><a href=\"#tab1default\" data-toggle=\"tab\"><h5>Profil</h5></a></li>
                    <li><a href=\"#tab2default\" data-toggle=\"tab\"><h5>Missions</h5></a></li>
                    <li><a href=\"#tab3default\" data-toggle=\"tab\"><h5>A venir</h5></a></li>
                </ul>
                <div class=\"tab-content\">
                    <div class=\"tab-pane fade\" id=\"tab2default\">
                            {#Affichage mission#}                        
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Liste des missions à postuler
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
                                    </table>
                                    </div>
                                    {% set compteur1 = 0 %}
                                    {% for missions in missionpostule %}
                                        {% if missions.missionid == mission.id and missions.postule == 1 %}
                                            {% set compteur1 = 1 %}
                                        {% endif %}
                                    {% endfor %}
                                    {% if compteur1 == 0 %}
                                            <center><span><a type=\"button\" class=\"btn btn-success\" 
                                            href=\"{{ path('bacloocrm_postulermission', {'id': mission.id}) }}\">Postuler</span></a></span></center>
                                    {% else %}
                                            <center><span>Déjà postulé</span></center>
                                    {% endif %}
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
                                    </table>
                                    </div>
                                    {% set compteur1 = 0 %}
                                    {% for missions in missionpostule %}
                                        {% if missions.missionid == mission.id and missions.postule == 1 %}
                                            {% set compteur1 = 1 %}
                                        {% endif %}
                                    {% endfor %}
                                    {% if compteur1 == 0 %}
                                            <center><span><a type=\"button\" class=\"btn btn-success\" 
                                            href=\"{{ path('bacloocrm_postulermission', {'id': mission.id}) }}\">Postuler</span></a></span></center>
                                    {% else %}
                                            <center><span>Déjà postulé</span></center>
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
                            </div>
                        </div>
                            {#Fin affichage mission#}
                    </div>

                    <div class=\"tab-pane fade in active\" id=\"tab1default\">
                        {#Affichage profil#}                        
                        <div class=\"panel panel-default\">
                            <div class=\"panel-body\">
                                <form class=\"form-horizontal\" action=\"{{ path('bacloocrm_employe') }}\"  method=\"post\" {{form_enctype(form) }}>
                                    <div class=\"form-group\">
                                        <div class=\"col-md-6\">
                                            <div class=\"input-group\">
                                                {{ form_widget(form.nom, {'value': userdetails.nom, 'attr' : { 'class' : 'form-control', 'placeholder' : 'Nom' } })  }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"form-group\">
                                        <div class=\"col-md-6\">
                                            <div class=\"input-group\">
                                                {{ form_widget(form.prenom, {'value': userdetails.prenom, 'attr' : { 'class' : 'form-control adresse2', 'placeholder' : 'Prénom' } })  }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"form-group\">
                                        <div class=\"col-md-6\">
                                            <div class=\"input-group\">
                                                {{ form_widget(form.datenaissance, {'value': userdetails.datenaissance|date('d/m/Y'), 'attr' : { 'class' : 'form-control datepicker', 'placeholder' : 'Date de naissance' } })  }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"form-group\">
                                        <div class=\"col-md-6\">
                                            <div class=\"input-group\">
                                                {{ form_widget(form.email, {'value': userdetails.email, 'attr' : { 'class' : 'form-control', 'placeholder' : 'email' } })  }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"form-group\">
                                        <div class=\"col-md-6\">
                                            <div class=\"input-group\">
                                                {{ form_widget(form.rib, {'value': userdetails.rib, 'attr' : { 'class' : 'form-control', 'placeholder' : 'RIB' } })  }}
                                            </div>
                                        </div>
                                    </div>
                                    {% if documents is empty %}
                                        {# Dropzone #}
                                        <div class=\"row clearfix\">
                                            <div class=\"col-sm-12\">
                                                <center><div class=\"dropzone col-md-6\" id=\"my-awesome-dropzone\" style=\"border-style: dashed solid; height:80px; width:200px;\"><div class=\"dz-message\" data-dz-message><span>Cliquez ou glissez votre photo ici</span></div></div></center>
                                            </div>
                                        </div>
                                    {% else %}
                                        <div class=\"row clearfix\">
                                            <div class=\"col-md-12\">
                                                <table>
                                                    <tr>
                                                        {% for document in documents %}
                                                            <td>
                                                                <img width=\"200\" src=\"{{ asset('uploads/employe/'~ userdetails.id ~'/' ~ document.nom ~ '') }}\">
                                                            </td>
                                                            <td class=\"col-md-10 pull-right\">
                                                                <a href=\"{{ path('bacloocrm_removedocument', {'iddoc': document.id, 'codedocument': userdetails.id, 'type':'employe' }) }}\"><i class=\"fa fa-times\"></i></a>
                                                            </td>
                                                        {% endfor %}
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    {% endif %}
                                    <br>
                                    <button type=\"submit\" class=\"btn btn-info\">
                                        Enregistrer
                                    </button>
                                </form>
                            </div>
                        </div>
                        {#Fin affichage profil#}

                        {# Affichage missions passées #} 
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Liste de vos missions passées
                                </h3>
                            </div>
                            <div class=\"panel-body\"> 
                            {% set compteur = 0 %}
                            <table>
                            {% for mission in missionpasse %}
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
                                    <center><span>Mission terminée</span></center>
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
                            </div>
                        </div>                      
                        {# Fin affichage missions passées #}   
                    </div>

                    <div class=\"tab-pane fade\" id=\"tab3default\">
                    {# Affichage missions du jour #} 
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Missions du jour
                                </h3>
                            </div>
                            <div class=\"panel-body\"> 
                            {% set compteur = 0 %}
                            <table>
                            {% for mission in missionjour %}
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
                                    </table>
                                    </div>
                                    <center><span>Mission à venir</span></center>
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
                            </div>
                        </div>
                    {# Fin affichage missions du jour #}
                    {# Affichage missions à venir #}
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3 class=\"panel-title\">
                                    Liste des missions à venir
                                </h3>
                            </div>
                            <div class=\"panel-body\"> 
                            {% set compteur = 0 %}
                            <table>
                            {% for mission in missionfutur %}
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
                                    </table>
                                    </div>
                                    <center><span>Mission à venir</span></center>
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
                            </div>
                        </div>
                    {# Fin affichage missions à venir #}
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
</script>\t

<script>
    // init,configure dropzone
    Dropzone.autoDiscover = true;
    var dropzone_default = new Dropzone(\".dropzone\", {
        url: '{{ path('bacloocrm_dropzone', {'codedocument':userdetails.id, 'type':'employe'}) }}',
        maxFiles: 1,
        dictMaxFilesExceeded: 'Only 1 Image can be uploaded',

        acceptedFiles: '.jpg, .jpeg, .png, .bmp, .pdf',
        maxFilesize: 3,  // in Mb
        addRemoveLinks: true,
        init: function () {
            this.on(\"maxfilesexceeded\", function(file) {
                this.removeFile(file);
            });
            this.on(\"sending\", function(file, xhr, formData) {
                // send additional data with the file as POST data if needed.
                // formData.append(\"key\", \"value\");  
            });
            this.on(\"success\", function() {
                if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                        location.reload();
                }
            });
        }
    });
</script>
{% endblock %}", "BaclooCrmBundle:Crm:employe.html.twig", "C:\\wamp\\www\\sar\\src\\Bacloo\\CrmBundle/Resources/views/Crm/employe.html.twig");
    }
}
