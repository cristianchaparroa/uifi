$(function(){
    var service = new Service();
    var baseUrl= location.protocol + "//" + location.host;
    var url = baseUrl +  Routing.generate('revistas_getlistarevista');
    var resquest = service.getService(url,{});
    var html  = '<table id="gruplac-table"   data-toggle="table" data-toolbar="#toolbar"   data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-show-export="true" data-show-pagination-switch="true" data-pagination="true">';
    html += '<thead> <tr><th data-field="id" data-sortable="true">ISBN</th><th>Nombre de la Revista</th></tr>';
    request.then(function(data){
      //TODO: verificar que sirve la lista dinamica
      var revistas = data.revistas;
      $.each(revistas,function(){
        var row = '<td><tr>'+$(this).isbn+'</tr><tr>'+$(this).nombre+'</tr></td>';
        html+= row;
      });
    });
    html += '</table>';
});
