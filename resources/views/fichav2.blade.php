<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@{{nombre}}</title>
  <meta name="description" v-bind:content="desc_ppi">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/styles.css"/>
  <link rel="stylesheet" type="text/css" href="js/bower_components/leaflet/dist/leaflet.css">
  <script src="js/modernizr.custom.js"></script>
</head>
<body class="record">
  <!--header-->
  <div class="col-sm-3 zero">
    <header class="top">
     <a class="tp">Transparencia Presupuestaria</a>
    </header>
  </div>
  <div class="col-sm-9 zero">
    <header class="top title_side">
      <a href="http://www.transparenciapresupuestaria.gob.mx/en/PTP/Obra_Publica_Abierta" class="link_back">&lt; Ir a Mapa de Obra Pública</a>
    </header>
  </div>
  <div class="clearfix"></div>
<div class="container">
  <!--content-->
  <div id="chupar-faros" style="display: none;">
	  <section>
  	<div class="row">
	  	<div class="col-sm-10 col-sm-offset-1">
	  		<h1>Lo sentimos, algo falló en nuestro sitio</h1>
	  		<h2>¿Qué pudo fallar?</h2>
	  		<ol>
		  		<li>Algo técnico falló</li>
		  		<li>El enlace pudo ser viejo y no se encuentra en el sitio</li>
		  		<li>Accidentalmente escribiste mal la dirección URL </li>
	  		</ol>
	  		<h2>¿Qué puedes hacer?</h2>
	  		<p>Puedes consultar esta página más tarde, o intentar escribir la URL otra vez.</p>
	  		<p>O puedes regresar al mapa de <a href="http://www.transparenciapresupuestaria.gob.mx/en/PTP/Obra_Publica_Abierta" class="link_back">Obra Pública</a>.</p>
	  	</div>
  	</div>
	  </section>
  </div>
  <section class="GF-card">
    <!--titles -->
    <div class="row">
      <div class="col-md-10 col-sm-9">
        <div class="row">
          <div class="col-sm-6">
            <h3>Programa o Proyecto de Inversión
              <!--tooltip-->
              <span class="tooltip">
                <span class="tooltip-item">(PPI) <b>?</b></span>
                <span class="tooltip-content clearfix">
                  <span class="tooltip-text"><strong>Programa o Proyecto de Inversión,</strong> es el nombre del programa o proyecto de inversión establecido por cada unidad responsable, que lo identifica claramente.</span>
                </span>
              </span>
            </h3>
          </div>
          <!--- clave de cartera-->
          <div class="col-sm-6">
            <h3 class="right">Clave de Cartera: <span id="cveReport">@{{cve_ppi}}</span></h3>
          </div>
        </div>
        <h1 id ="nameReport">@{{nombre}}</h1>
        <div class="row">
          <div class="col-md-10 col-sm-9">
            <p>@{{desc_ppi}}</p>
          </div>
          <div class="col-md-2 col-sm-3">
	        <div v-if="fase == 'Vigente'">
           	 <h3 class="right">Fase: <span class="active">@{{fase}}</span></h3>
	        </div>
            <div v-else>
	            <h3 class="right">Fase: <span class="disabled">@{{fase}}</span></h3>
            </div>
          </div>
        </div>
      </div>
      <!--avance fisico-->
      <div id="arc_side" class="col-md-2 col-sm-3 side">
        <h3>Avance Físico Total</h3>
      </div>
    </div>

    <!--mapa y montos-->
    <div class="row">
      <div class="col-md-9 col-sm-8">
        <div class="row">
          <!-- Ramo-->
          <div class="col-md-4 col-sm-7">
            <h3 class="title line">
              <!--tooltip-->
              <span class="tooltip">
                <span class="tooltip-item">Ramo <b>?</b></span>
                <span class="tooltip-content clearfix">
                  <span class="tooltip-text"><strong>Ramo</strong>. Categoría administrativa a la que pertenece el programa presupuestario, de acuerdo con la estructura programática del PEF vigente</span>
                </span>
              </span>


            </h3>
            <p class="fichas_ramo"><b v-bind:class="['ramo' + id_ramo,]"></b>@{{id_ramo}} - @{{desc_ramo}}</p>
          </div>
          <!-- Ejecutor-->
          <div class="col-md-4 col-sm-5">
            <h3 class="title line">Ejecutor del Proyecto</h3>
            <p id = "ejecutorReport">@{{id_ur}} - @{{desc_ur}}</p>
          </div>
          <!-- Tipo de proyecto-->
          <div class="col-md-4 col-sm-12">
            <h3 class="title line">
              <!--tooltip-->
              <span class="tooltip">
                <span class="tooltip-item">Tipo de Proyecto <b>?</b></span>
                <span class="tooltip-content clearfix">
                  <span class="tooltip-text">Descripción del tipo de programa o proyecto de inversión a ejecutar, de acuerdo con su finalidad y función</span>
                </span>
              </span>
            </h3>
            <p>@{{ tipo_ppi }}</p>
          </div>
        </div>

        <!--mapa-->
        <!--<iframe width="100%" height="350px" frameborder="0" scrolling="no" v-bind:src="map_src"></iframe>-->
        <div id="GF-SHCP-map" style="width:100%; height:350px; frameborder:0; scrolling:no;"></div>

        <div class="info location">
          <div class="row">
	        <!--programa-->
          	<div class="col-md-4 col-sm-12">
              <h3 class="title">Programa Presupuestario</h3>
              <ul id="GF-SHCP-links"></ul>
            </div>
            <div class="col-md-8  col-sm-12">
            	<div class="row">
			    <!--localizacion-->
			   <div class="col-sm-12">
			     <h3 class="title">Localización</h3>
			     <p>@{{localizacion}}</p>
			   </div>

            	<!---entidad-->
          		<div class="col-md-6 col-sm-12">
            	  <h3 class="title">Entidad Federativa</h3>
            	  <p id="entidadReport">	@{{entidad_federativa}}</p>
            	</div>
            	<!---coordenadas---->
          		<div class="col-md-6 col-sm-12">
            	  <h3 class="title">Coordenadas Geográficas</h3>
            	  <p>Latitud: @{{latitud_inicial}} <br> Longitud: @{{longitud_inicial}}</p>
            	</div>
            	</div>
            </div>

          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-4 side">
        <!-- monto total-->
        <h3>
          <!--tooltip-->
          <span class="tooltip">
            <span class="tooltip-item">Monto total de inversión <b>?</b></span>
            <span class="tooltip-content clearfix">
              <span class="tooltip-text">La suma de la totalidad de recursos destinados a la ejecución de un programa o proyecto de inversión, incluyendo los recursos fiscales y los recursos que se obtienen de otras fuentes de financiamiento</span>
            </span>
          </span>
        </h3>
        <p class="amount big right">$<strong>@{{Format(monto_total_inversion)}}</strong> <span>MXN</span></p>
        <div class="bar">
          <span class="bar inside total"></span>
        </div>
		
		
		<div v-if="monto_aprobado != null">
       		<!-- pef-->
       		<h3>Monto aprobado</h3>
       		<p class="amount right">$<strong>@{{Format(monto_aprobado)}}</strong> <span>MXN</span></p>
       		<div class="bar">
       		  <span class="bar inside pef" v-bind:style="presupuesto_style"></span>
       		</div>
		</div>
		
		<div v-if="monto_modificado != null">
        	<!-- modificado-->
        	<h3>Monto modificado</h3>
        	<p class="amount right">$<strong>@{{Format(monto_modificado)}}</strong> <span>MXN</span></p>
        	<div class="bar">
        	  <span class="bar inside modificado" v-bind:style="modificado_style"></span>
        	</div>
		</div>
		
		<div v-if="monto_ministrado != null">
        	<!-- ministrado-->
        	<h3>Monto ministrado</h3>
        	<p class="amount right">$<strong>@{{Format(monto_ministrado)}}</strong> <span>MXN</span></p>
        	<div class="bar">
        	  <span class="bar inside modificado" v-bind:style="modificado_style"></span>
        	</div>
		</div>
		
		<div v-if="monto_comprometido != null">
        	<!-- ministrado-->
        	<h3>Monto comprometido</h3>
        	<p class="amount right">$<strong>@{{Format(monto_comprometido)}}</strong> <span>MXN</span></p>
        	<div class="bar">
        	  <span class="bar inside modificado" v-bind:style="modificado_style"></span>
        	</div>
		</div>
		
		<div v-if="monto_devengado != null">
        	<!-- ministrado-->
        	<h3>Monto devengado</h3>
        	<p class="amount right">$<strong>@{{Format(monto_devengado)}}</strong> <span>MXN</span></p>
        	<div class="bar">
        	  <span class="bar inside modificado" v-bind:style="modificado_style"></span>
        	</div>
		</div>
		
		<div v-if="monto_ejercido != null">
        	<!-- ejercido-->
        	<h3>Monto ejercido</h3>
        	<p class="amount right">$<strong>@{{Format(monto_ejercido)}}</strong> <span>MXN</span></p>
        	<div class="bar">
        	<span class="bar inside ejercido" v-bind:style="total_ejercido_style"></span>
        	</div>
        </div>
        
        <div v-if="monto_pagado != null">
        	<!-- pagado-->
        	<h3>Monto pagado</h3>
        	<p class="amount right">$<strong>@{{Format(monto_pagado)}}</strong> <span>MXN</span></p>
        	<div class="bar">
        	<span class="bar inside ejercido" v-bind:style="total_ejercido_style"></span>
        	</div>
        </div>
        
        <div v-if="monto_pagado != null">
        	<!-- avance-->
        	<h3>Avance financiero</h3>
        	<p class="amount right">$<strong>@{{Format(avance_financiero)}}</strong> <span>MXN</span></p>
        	<div class="bar">
        	<span class="bar inside ejercido" v-bind:style="total_ejercido_style"></span>
        	</div>
        </div>
		
		
		
        <!-- reporta obra-->
        <button id="show-modal" @click="showModal = true" class="btn report trigger">Reporta esta obra</button>

      </div>
    </div>
  </section>



  <!--metas -->
  <section class="GF-card">
    <div class="row">
      <div class="col-sm-12">
        <h2>Metas</h2>
      </div>
      <!--física-->
      <div class="col-sm-6">
        <h3 class="title">
          <!--tooltip-->
          <span class="tooltip">
            <span class="tooltip-item">Meta Física <b>?</b></span>
            <span class="tooltip-content clearfix">
              <span class="tooltip-text">La producción de bienes y servicios que se pretenden alcanzar con el programa o proyecto de inversión</span>
            </span>
          </span>
        </h3>
        <p>@{{meta_fisica}}</p>
      </div>
      <!--física-->
      <div class="col-sm-6">
        <h3 class="title">

          <!--tooltip-->
          <span class="tooltip">
            <span class="tooltip-item">Beneficios esperados del PPI <b>?</b></span>
            <span class="tooltip-content clearfix">
              <span class="tooltip-text">Efectos favorables que se generarían sobre la población o para el país como resultado del programa o proyecto de inversión</span>
            </span>
          </span>
        </h3>
        <p>@{{meta_beneficios}}</p>
      </div>
    </div>
  </section>


 

  <!--otras fuentes-->
  <section class="GF-card">
    <div class="row">
      <div class="col-sm-12">
        <h2>Otras fuentes de financiamiento</h2>
       <!--<p>No se ha reportado información sobre otras fuentes de financiamiento de este PPI.</p>-->
      </div>
      <!--recursos estatales-->
      <div class="col-sm-3">
	      <h3>Recursos Estatales</h3>
		  <p class="amount" v-if="recursos_estatales">$<strong>@{{Format(recursos_estatales)}}</strong></p>
		  <p class="amount" v-else>$<strong>@{{Format(0)}}</strong></p>
      </div>
      <!--recursos municipales-->
      <div class="col-sm-3">
	      <h3>Recursos Municipales</h3>
		  <p class="amount" v-if="recursos_municipales">$<strong>@{{Format(recursos_municipales)}}</strong></p>
		  <p class="amount" v-else>$<strong>@{{Format(0)}}</strong></p>
      </div>
	  <!--privados-->
      <div class="col-sm-3">
	      <h3>Recursos Privados</h3>
		  <p class="amount" v-if="privados">$<strong>@{{Format(privados)}}</strong></p>
		  <p class="amount" v-else>$<strong>@{{Format(0)}}</strong></p>
      </div>
	  <!--fideicomiso-->
      <div class="col-sm-3">
	      <h3>Fideicomiso</h3>
		  <p class="amount" v-if="fideicomiso">$<strong>@{{Format(fideicomiso)}}</strong></p>
		  <p class="amount" v-else>$<strong>@{{Format(0)}}</strong></p>
      </div>
    </div>
  </section>

  <!--Comentarios---------->
  <section id="gf-commentarios" class="GF-card">
    <div class="row">
      <div class="col-sm-12">
        <h2>Notas</h2>
		<ul id="GF-SHCP-comments"></ul>
      </div>
    </div>
  </section>


  <!--responsable---------->
  <section class="GF-card">
    <div class="row">
      <div class="col-sm-12">
        <h2>Responsable</h2>
        <table class="table">
          <thead>
            <th>Nombre</th>
            <th>Apellido Paterno</th>
            <th>Apellido  Materno </th>
            <th>Cargo       </th>
            <th>Correo electrónico  </th>
            <th>Teléfono      </th>
          </thead>
          <tbody>
            <tr>
              <td>@{{nombre_admin}}              </td>
              <td>@{{ap_paterno_admin}}            </td>
              <td>@{{ap_materno_admin}}               </td>
              <td>@{{cargo_admin}}             </td>
              <td><a v-bind:href="mail_to_admin">@{{mail_admin}}</a></td>
              <td>@{{telefono_admin}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!--documentos adjuntos--->
  <section class="GF-card">
    <div class="row">
      <div class="col-sm-12">
        <h2>Documentos Adjuntos</h2>
        <table class="table">
          <thead>
            <th>Nombre</th>
            <th>Tipo de Documento</th>
            <th>Fecha</th>
          </thead>
          <tbody>
            <tr>
              <td><a href="#" download>@{{desc_documento}}</a></td>
              <td>@{{tipo_documento}}</td>
              <td>@{{fecha_documento}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
  
  <!--contratos-->
  <section class="GF-card">
    <div class="row">
      <div class="col-sm-12">
	      <h2>Contratos</h2>
	      <table class="table">
          <thead>
            <th>Número de Contrato</th>
            <th>Proveedor</th>
            <th>Unidad Compradora</th>
            <th>URL       </th>
          </thead>
          <tbody>
            <tr>
              <td>@{{id_contrato}}              </td>
              <td>@{{razon_social_contratista}}            </td>
              <td>@{{unidad_compradora}}               </td>
              <td>@{{liga_contrato}}</td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
  </section>
  
   <!--galeria de imagenes-->
  <section class="GF-card">
    <div class="row">
      <div class="col-sm-12">
	      <h2>Galería de imágenes</h2>
      </div>
      <div class="col-sm-4">
	      <h3 class="title">Antes</h3>
      </div>
      <div class="col-sm-4">
	      <h3 class="title">Durante</h3>
      </div>
      <div class="col-sm-4">
	      <h3 class="title">Después</h3>
      </div>
     <!-- <div id="demo">
                <vue-images :imgs="images"
                            :modalclose="modalclose"
                            :keyinput="keyinput"
                            :mousescroll="mousescroll"
                            :showclosebutton="showclosebutton"
                            :showcaption="showcaption"
                            :imagecountseparator="imagecountseparator"
                            :showimagecount="showimagecount"
                            :showthumbnails="showthumbnails">
                </vue-images>
              </div>-->
    </div>
  </section>
  
     <!--operación-->
  <section class="GF-card">
    <div class="row">
      <div class="col-sm-12">
        <h2>Datos sobre la etapa de operación</h2>
      </div>
      <!--años-->
      <div class="col-sm-3">
        <p class="amount"><strong>@{{anios_he}}</strong> años</p>
        <p class="lead">Número estimado de años de operación en el horizonte de evaluación
          <!--tooltip-->
          <span class="tooltip">
            <span class="tooltip-item"><b>?</b></span>
            <span class="tooltip-content clearfix">
              <span class="tooltip-text">Período que comprende tanto la etapa de ejecución como de operación de un programa o proyecto de inversión</span>
            </span>
          </span>
        </p>
      </div>
      <!--gastos-->
      <div class="col-sm-3">
        <p class="amount">$<strong>@{{Format(total_gasto_operacion_he)}}</strong></p>
        <p class="lead">Gastos estimados totales de mantenimiento y operación del activo en el horizonte de evaluación
	      <!--tooltip-->
          <span class="tooltip">
            <span class="tooltip-item"><b>?</b></span>
            <span class="tooltip-content clearfix">
              <span class="tooltip-text">Monto estimado global de recursos que se requerirán para el funcionamiento adecuado de los activos derivados de un programa o proyecto de inversión</span>
            </span>
          </span>
        </p>
      </div>
      <!--otros costos-->
      <div class="col-sm-3">
        <p class="amount">$@{{Format(total_gasto_no_consid)}}</p>
        <p class="lead">Otros costos y gastos asociados al PPI que no forman parte del gasto de inversión ni de los gastos de operación y mantenimiento
	      <!--tooltip-->
          <span class="tooltip">
            <span class="tooltip-item"><b>?</b></span>
            <span class="tooltip-content clearfix">
              <span class="tooltip-text">Monto estimado de recursos asociados a la ejecución del programa o proyecto de inversión distintos a los gastos de inversión, operación y mantenimiento</span>
            </span>
          </span>
        </p>
      </div>
      <!--costo total-->
      <div class="col-sm-3">
        <p class="amount">$<strong>@{{Format(costo_total_ppi)}}</strong></p>
        <p class="lead">Costo Total del PPI
	        <!--tooltip-->
          <span class="tooltip">
            <span class="tooltip-item"><b>?</b></span>
            <span class="tooltip-content clearfix">
              <span class="tooltip-text">La suma del monto total de inversión, los gastos estimados de operación y mantenimiento, y los otros costos y gastos asociados</span>
            </span>
          </span>
        </p>
      </div>
    </div>
  </section>
  
   <!--calendario fiscal-->
  <section class="GF-card">
    <div class="row">
      <div class="col-sm-12">
	      
        <h2>Calendario Fiscal
          <!--tooltip-->
          <span class="tooltip">
            <span class="tooltip-item"> <b>?</b> <span class="h2title">Calendario Fiscal</span></span>
            <span class="tooltip-content clearfix">
              <span class="tooltip-text">Monto máximo de recursos programados por la dependencia para ejercer durante el año. Se diferencia del aprobado porque no depende de sus capacidades de pago sino de estimaciones propias de la dependencia.</span>
            </span>
          </span>
        </h2>
      </div>
      <!--inicio-->
      <div class="col-sm-4">
        <h3>Fecha de inicio de inversión:</h3>
        <p>@{{fecha_ini_cal_fiscal}}</p>
      </div>
      <!--término-->
      <div class="col-sm-4">
        <h3>Fecha de término de inversión:</h3>
        <p>@{{fecha_fin_cal_fiscal}}</p>
      </div>
      <!--total-->
      <div class="col-sm-4">
        <h3>Monto total de inversión:</h3>
        <p>$@{{Format(monto_total_inversion)}}</p>
      </div>
      <!--gráfica--->
      <div class="col-sm-9">
        <div id="graph" class="graph">
        </div>
      </div>
      
      <!--tabla-->
      <div class="col-sm-3 side">
        <table class="table">
          <thead>
            <tr>
              <th>Año de Inversión</th>
              <th>Monto</th>
            </tr>
          </thead>
          <tbody>
            <tr><td>2017</td>
            <td class="right"><strong>$109,814,311</strong></td></tr>
            <tr><td>2016</td>
            <td class="right"><strong>$101,313,120</strong></td></tr>
            <tr><td>2015</td>
            <td class="right"><strong>$208,539,823</strong> </td></tr>
            <tr><td>2014</td>
            <td class="right"><strong>$54,564,412 </strong>  </td></tr>
            <tr><td>2013</td>
            <td class="right"><strong>$300,157,683</strong> </td></tr>
            <tr><td>2012</td>
            <td class="right"><strong>$215,044,846</strong> </td></tr>
            <tr><td>2011</td>
            <td class="right"><strong>$25,873,394 </strong>  </td></tr>
            <tr><td>2010</td>
            <td class="right"><strong>$25,741,318 </strong>  </td></tr>
            <tr><td>2009</td>
            <td class="right"><strong>$12,287,059 </strong>  </td></tr>
            <tr><td>2008</td>
            <td class="right"><strong>$4,337,408  </strong>  </td></tr>
            <tr><td>2007</td>
            <td class="right"><strong>$0      </strong>  </td></tr>
            <tr><td>2006</td>
            <td class="right"><strong>$2,385    </strong>  </td></tr>

          </tbody>
        </table>
      </div>
    </div>
  </section>
  
  
  <!-- reportar-->
  <section class="GF-card">
    <div class="row">
      <div class="col-sm-12">
       <!-- <p class="update right">Información actualizada al primer trimestre de 2016</p>-->
      </div>
      <div class="col-sm-12">
        <a id="red" class="btn report large trigger" @click="showModal = true" data-dialog="somedialog">Reporta esta Obra</a>
      </div>
    </div>
    <!-- modal -->
	  <modal v-if="showModal" @close="showModal = false">
	  <!-- content-->
	  <h2 slot="header">Reporta esta obra</h2>

	  <div class="dialog-container" slot="body">

		<div id="reporte_step0">
		  <p slot="header">Realiza tu reporte ciudadano para este proyecto:</p>
     	<div class="row">
        	<div class="col-sm-4">
        	  <a class="btn_type" @click="step1">
        	    <span class="btn-content">No coincide el avance físico  que aparece en el PTP con el que ves en la obra</span>
        	    <span class="btn-symbol">Reportar</span>
        	  </a>
        	</div>
        	<div class="col-sm-4">
        	  <a class="btn_type" @click="step1">
        	    <span class="btn-content">La obra ha sido abandonada</span>
        	    <span class="btn-symbol">Reportar</span>
        	  </a>
        	</div>
        	<div class="col-sm-4">
        	  <a class="btn_type" @click="step1">
        	    <span class="btn-content">Existe un error en la localización</span>
        	    <span class="btn-symbol">Reportar</span>
        	  </a>
        	</div>
        </div>
		<h3>Preguntas Frecuentes</h3>
		<ul id="toggle-view">
        <li @click="listfaqs">
          <h4>¿Qué es un reporte ciudadano?</h4>
          <span>+</span>
          <div class="panel">
          Aviso que realiza cualquier interesado, a través de medios electrónicos, sobre posibles observaciones relacionadas con la ubicación, avances físicos y financieros o condiciones físicas de los programas y proyectos de inversión registrados en la Cartera de Inversión y en proceso de ejecución, susceptibles de ser georreferenciados.</div>
        </li>
        <li @click="listfaqs">
        	<h4>¿Puedo presentar una queja o denuncia sobre algún funcionario público en particular a través de la plataforma?</h4>
          <span>+</span>
          <div class="panel">Para ello, la Secretaría de la Función Pública pone a disposición de los ciudadanos distintos mecanismos que se pueden consultar a través de la página <a href="http://www.funcionpublica.gob.mx/index.php/temas/quejas-y-denuncias.html">http://www.funcionpublica.gob.mx/index.php/temas/quejas-y-denuncias.html</a></div>
        </li>
        <li @click="listfaqs">
        	<h4>¿Qué es la Cartera de Inversión?</h4>
          <span>+</span>
          <div class="panel">La Cartera es un sistema electrónico que contiene la información de todos los programas y proyectos de inversión que las dependencias y entidades de la Administración Pública Federal registraron y que demostraron tener beneficios para la población (rentables socioeconómicamente).</div>
        </li>
        <li @click="listfaqs">
          <h4>¿Cuál es el procedimiento para registrar un proyecto de inversión?</h4>
          <span>+</span>
          <div class="panel">El proceso comienza con la identificación de necesidades de la población por parte de las dependencias y entidades de la Administración Pública Federal, las cuales analizan, evalúan y formulan proyectos o programas de inversión con el fin de satisfacer dichas necesidades. La solicitud de registro, la cual debe cumplir con la normatividad vigente, la realizan las dependencias y entidades mediante los sistemas informáticos de la Secretaría de Hacienda y Crédito Público (SHCP). Posteriormente, la solicitud es revisada por la Unidad de Inversiones de la SHCP y una vez que el proyecto demuestra que tiene beneficios para la población, se le otorga el registro en la Cartera de Inversión.</div>
        </li>
        <li @click="listfaqs">
        	<h4>¿Por qué no se ha aprobado mi proyecto?</h4>
          <span>+</span>
          <div class="panel">Sólo los programas y proyectos que las dependencias y entidades de la Administración Pública Federal registran en los sistemas informáticos de la SHCP son susceptibles de registro en la Cartera. Para que los proyectos puedan ser aprobados, deben cumplir los requisitos establecidos en la normatividad vigente, por lo que son revisados estrictamente para poder ser autorizados.</div>
        </li>
        <li @click="listfaqs">
          <h4>¿Por qué mi proyecto no recibió recursos?</h4>
          <span>+</span>
          <div class="panel">Derivado del hecho que los recursos son limitados, la dependencia o entidad determina, de acuerdo con su planeación, qué proyectos son prioritarios para asignarles recursos durante el ejercicio fiscal, además, dichos recursos son aprobados por la Cámara de Diputados, junto con la totalidad del Presupuesto de Egresos de la Federación, en el mes de noviembre de cada año.</div>
        </li>
        <li @click="listfaqs">
          <h4>¿Cuál es la normatividad vigente para registrar un proyecto de inversión?</h4>
          <span>+</span>
          <div class="panel">Para llevar a cabo el registro de un programa o proyecto de inversión se debe cumplir lo establecido en los Lineamientos para el registro en la cartera de programas y proyectos de inversión, los cuales se encuentran disponibles en la página de la SHCP: <a href="http://www.shcp.gob.mx/LASHCP/MarcoJuridico/ProgramasYProyectosDeInversion/Paginas/lineamientos.aspx">http://www.shcp.gob.mx/LASHCP/MarcoJuridico/ProgramasYProyectosDeInversion/Paginas/lineamientos.aspx</a></div>
        </li>
      </ul>
		<a href="http://transparenciapresupuestaria.gob.mx/es/PTP/PreguntasFrecuentes" class="btn more">Más preguntas frecuentes</a>
		</div>

		<form id = "reportForm">
			<!-- paso 1-->
			<fieldset id="reporte_step1" class="hide">
				<h3>Paso 1 de 2</h3>
				<ul class="step_n">
					<li><a class="active"></a></li>
					<li><a></a></li>
				</ul>
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<label>Asunto del reporte</label>
						<textarea id="asuntoReporte"></textarea>
						<label>Narre el motivo de su reporte</label>
						<textarea id="motivoReporte"></textarea>
						<a class="btn more" @click="step2">Continuar &gt;</a>
					</div>
				</div>
			</fieldset>

			<!-- paso 2-->
			<fieldset id="reporte_step2" class="hide">
				<h3>Paso 2 de 2</h3>
				<ul class="step_n">
					<li><a class="complete"></a></li>
					<li><a class="active"></a></li>
				</ul>
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<h3>Tu denuncia puede ser anónima o puedes proporcionar tu información de contacto básica
							para dar seguimiento a tu solicitud.</h3>
							<p class="center"><span class="small"><span class="alert">*</span> Información necesaria </span></p>
						<label>¿Deseas que tu denuncia sea reportada como anónima?<span class="alert">*</span></label>
              {{ csrf_field() }}
						<select id="anonymous">
						  <option value="0">No</option>
						  <option value="1">Sí</option>
						</select>
					</div>
				</div>
				<div id = "noAnonymous">
					<div class="row">

						<div class="col-sm-5 col-sm-offset-1">
							<label>Nombre(s) <span class="alert">*</span></label>
							<input id="name" type="text" name="name">
						</div>
						<div class="col-sm-5">
							<label>Paterno <span class="alert">*</span></label>
							<input id="surname"  type="text" name="surname">
						</div>
						<div class="col-sm-5 col-sm-offset-1">
							<label>Materno</label>
							<input id="lastname"  type="text" name="lastname">
						</div>
						<div class="col-sm-5">
							<label>Género <span class="alert">*</span></label>
							<select id="gender">
							  <option value="MUJER">Femenino</option>
							  <option value="HOMBRE">Masculino</option>
							</select>
						</div>
						<div class="col-sm-5 col-sm-offset-1">
							<label>Correo <span class="alert">*</span></label>
							<input id="email" type="text" name="email">
						</div>
						<div class="col-sm-5">
							<label>Contraseña <span class="alert">*</span></label>
							<input id="password" type="text" name="password">
						</div>
					</div>
          		</div>
		  		<div class="row">
					<div class="col-sm-3 col-sm-offset-1">
						<a class="btn more back" @click="step2">&lt; Regresar</a>
					</div>
					<div class="col-sm-4">
						<input class="rpt-advance" type="submit" value="Enviar Reporte &gt;">
					</div>
				</div>
			</fieldset>
		</form>



		<div id="respuesta_reporte" class="hide">
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<div id ="successReport">
							<h3>Recibimos tu reporte, en breve le daremos seguimiento</h3>
							<p>ID de reporte : <span id="folio"></span></p>
							<p>Contraseña reporte: <span id="passfolio"></span></p>
					</div>
					<div id ="errorReport" style= "display:none;">
					  <h3>Ocurrió un error al enviar tu reporte, inténtalo más tarde</h3>
					</div>
				</div>
			</div>
		</div>
	  </div>
	  </modal>

  </section>

</div><!--ends container-->

  <!--footer------->
  <footer>
    <div class="container">
      <div class="content">
        <div class="row">
          <div class="col-sm-4">
            <h3>Contacto</h3>
             <p class="data">Palacio Nacional <br>
               Plaza de la Constitución s/n<br>
               Colonia Centro, Delegación Cuauhtémoc<br>
               México, Ciudad de México</p>
          </div>

          <div class="col-sm-4">
            <ul>
              <li><a class="linksfoot" href="/es/PTP/Glosario">Glosario</a></li>
              <li><a class="linksfoot" href="/es/PTP/Mapa_de_Sitio">Mapa de sitio</a></li>
              <li><a class="linksfoot" href="/es/PTP/Estadisticas">Estadísticas del Portal</a></li>
            </ul>
            <ul>
              <!--fb-->
              <li><a href="http://www.facebook.com/TransparenciaPresupuestaria" class="fb" target="_blank">Facebook</a></li>
              <!--tw-->
              <li><a href="//twitter.com/TPresupuestaria" class="tw" target="_blank">Twitter</a></li>                 <!--youtube-->
              <li> <a href="http://www.youtube.com/channel/UCokAhIwndny0k2ROksI-qqg?sub_confirmation=1" class="youtube" title="Youtube" target="_blank">Youtube</a>
              </li>
              <li> <a href="mailto:trans_presupuestaria@hacienda.gob.mx" target="_blank" class="email" title="trans_presupuestaria@hacienda.gob.mx">Email</a></li>
            </ul>
          </div>

          <div class="col-sm-4 right">
            <h3>Última actualización:</h3>
             <p class="data">Jueves 1 de diciembre de 2016 a las 14:25 hrs.</p>
             <p class="right"><a href="http://www.hacienda.gob.mx" class="shcp">Secretaría de Hacienda y Crédito Público</a><span class="clearfix"></span></p>

          </div>
        </div>
      </div>
    </div>
    <div class="author">
      <div class="container">
        <div class="row">
          <div class="col-sm-4">
            <p class="data"><a href="http://www.transparenciapresupuestaria.gob.mx/" class="tp">Transparencia Presupuestaria</a> <a href="#" class="linksfoot">Términos y Condiciones del uso de la información.</a></p>
          </div>
          <div class="col-sm-4">
            <p class="data center">Forjado artesanalmente por <a href="http://www.gobiernofacil.com" class="gobiernofacil" title="Ir a Gobierno Fácil">Gobierno Fácil</a></p>
          </div>
          <div class="col-sm-4">
            <p class="data right"><span class="usaid">USAID</span></p>

          </div>
        </div>
      </div>
    </div>
  </footer>


<!-- template for the modal component -->
<script type="text/x-template" id="modal-template">
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <div class="modal-header">

            <slot name="header">
              default header

            </slot>
            <button class="modal-default-button action" @click="$emit('close')">X</button>
          </div>

          <div class="modal-body">
            <slot name="body">
              default body
            </slot>
          </div>

		 <!--
          <div class="modal-footer">
            <slot name="footer">
              default footer
            </slot>
          </div>
          -->
        </div>
      </div>
    </div>
  </transition>
</script>


<!-- libraries -->
<script src="js/d3.v3.min.js"></script>
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bower_components/vue/dist/vue.min.js"></script>
<script src="js/vue-images.js"></script>
<script src="js/bower_components/leaflet/dist/leaflet.js"></script>

<!-- config -->
<script>
  var Format         = d3.format(","),
      GFLinksBaseURL = "http://nptp.hacienda.gob.mx/programas/jsp/programas/fichaPrograma.jsp?id=",
      GFAPIBaseURL   = "https://datos.gob.mx/api/buda/v1/proyectos-opa",//"http://api.datos.gob.mx/v1/proyectos-opa",
      GFNotesFile    = "csv/notas.csv",
      GFLinksFile    = "csv/ppi-links.csv";
</script>




<!-- code -->
 <script src="js/card.js"></script>
 
 <script>
new Vue({
  el: '#demo',
  data () {
    return {
      images: [
        {
          imageUrl: 'https://images.unsplash.com/photo-1454991727061-be514eae86f7?dpr=2&auto=format&w=1024',
          caption: '<a href="#">Photo by 1</a>'
        },
        
        {
          imageUrl: 'https://images.unsplash.com/photo-1460899960812-f6ee1ecaf117?dpr=2&auto=format&w=1024',
          caption: 'Photo by 3'
        },
        {
          imageUrl: 'https://images.unsplash.com/photo-1456926631375-92c8ce872def?dpr=2&auto=format&w=1024',
          caption: 'Photo by 4'
        },
              ],
      modalclose: true,
      keyinput: true,
      mousescroll: true,
      showclosebutton: true,
      showcaption: true,
      imagecountseparator: 'of',
      showimagecount: true,
      showthumbnails: true
    }
  },
  components: {
    vueImages: vueImages.default
  }
})
</script>
 
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45473222-14', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
