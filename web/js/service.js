var Service  = function(){
   this.data = {};
};

Service.prototype.getService = function(url,data){
  var promise = $.ajax({
    url: url,
    async: false,
    crossDomain: true,
    method:'POST',
    data:data
  });
  return promise;
};
