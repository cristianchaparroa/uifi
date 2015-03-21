$(function()
{
    $("#uifi_reportes_articulo_grupo option[value='']").remove();
    $("#uifi_reportes_articulo_integrantes option[value='']").remove();

    $grupos = $("#uifi_reportes_articulo_grupo");
    $grupos.append($('<option>',{value: '',text: 'Seleccione...',selected: true,}));

    $integrantes = $("#uifi_reportes_articulo_integrantes");
    $integrantes.append($('<option>',{value: '',text: 'Seleccione...',selected: true,}));

    $('#investigador').hide();
    $('#discriminarIntegrante').hide();
    $('#uifi_reportes_articulo_discriminarGrupo_1').prop('checked', true);
    /**
     * Si se selecciona algún grupo de investigación se  muestran solo los
     * integrantes que pertenecen a ese grupo.
    */
    $('#uifi_reportes_articulo_grupo').on('change', function()
    {
      var baseUrl= location.protocol + "//" + location.host;
      var url = baseUrl +  Routing.generate('reportes_articulos_filtrar');
      var $data = {'grupo' : $( "#uifi_reportes_articulo_grupo option:selected" ).val() };
      console.log($data);
      $.ajax({
        url: url,
        data: $data,
        async: true,
        crossDomain: true,
        success: function(data)
        {
          if(data.success){
            $('#investigador').show();
            $('#discriminarGrupo').hide();
            $('#discriminarIntegrante').show();
            $('#uifi_reportes_articulo_discriminarIntegrante_1').prop('checked', true);
            $integrantesSelect = $("#uifi_reportes_articulo_integrantes");
            $integrantesSelect.empty();
            $integrantesSelect.append($('<option>',{value: '',text: 'Seleccione...',selected: true,}));
            var integrantes = data.integrantes;
            for( var i=0; i<integrantes.length; i++)
            {
                var integrante = integrantes[i];
                $integrantesSelect.append($('<option>',{value: integrante.id,text: integrante.nombre}));
                $integrantesSelect.trigger("chosen:updated");
            }

          }
          console.log(JSON.stringify(data));
        },
        error: function(xhr, status, error)
        {
          console.log( JSON.stringify(xhr) ) ;
          console.log( JSON.stringify(status) ) ;
          console.log( JSON.stringify(error) ) ;
        }
      }).always(function(){});
    });

    /**
     * Si se selecciona algún integrante
    */
    $('#uifi_reportes_articulo_integrantes').on('change', function()
    {
        $integrante =  $( "#uifi_reportes_articulo_integrantes option:selected" ).val();
        if( $integrante!=='' ){
          //$('#discriminar').hide();
          $('#uifi_reportes_articulo_discriminarIntegrante_0').prop('checked', true);
          $('#uifi_reportes_articulo_discriminarIntegrante_0').prop('disabled', true);
          $('#uifi_reportes_articulo_discriminarIntegrante_1').prop('disabled', true);
        }
        else{
          $('#uifi_reportes_articulo_discriminarIntegrante_0').prop('disabled', false);
          $('#uifi_reportes_articulo_discriminarIntegrante_1').prop('disabled', false);
        }
    });
});
