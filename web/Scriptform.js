
      $(document).ready(function() {
    var $container = $('div#cv_experiences');
    var index = $container.find(':input').length;
    $('#add_exp').click(function(e) {
      addCategory($container);
      e.preventDefault();
      return false;
    });

       if (index == 0) {
      addCategory($container);
    } else {
      $container.children('div').each(function() {
        addDeleteLink($(this));
      });
    }
    function addCategory($container) {
      var template = $container.attr('data-prototype')
        .replace(/__name__label__/g, 'Expériences n°' + (index+1))
        .replace(/__name__/g,        index)
      ;
      var $prototype = $(template);
      addDeleteLink($prototype);
      $container.append($prototype);
      index++;
    }
    function addDeleteLink($prototype) {
      var $deleteLink = $('<br><a href="#" class="btn btn-danger">Supprimer</a>');
      $prototype.append($deleteLink);
      $deleteLink.click(function(e) {
        $prototype.remove();
        e.preventDefault();
        return false;
      });
    }
  });


////////////////////////////////////////////////////////////////////

      $(document).ready(function() {
    var $containeri = $('div#cv_formations');
    var indexi = $containeri.find(':input').length;
    $('#add_formations').click(function(e) {
      addCategoryi($containeri);
      e.preventDefault();
      return false;
    });
      
       if (indexi == 0) {
      addCategoryi($containeri);
    } else {
      $containeri.children('div').each(function() {
        addDeleteLinki($(this));
      });
     }
    function addCategoryi($containeri) {
      var templatei = $containeri.attr('data-prototype')
        .replace(/__name__label__/g, 'Formations n°' + (indexi+1))
        .replace(/__name__/g,        indexi)
      ;
      var $prototypei = $(templatei);
      addDeleteLinki($prototypei);
      $containeri.append($prototypei);
      indexi++;
    }
    function addDeleteLinki($prototypei) {
      var $deleteLinki = $('<br><a href="#" class="btn btn-danger">Supprimer</a>');
      $prototypei.append($deleteLinki);
      $deleteLinki.click(function(e) {
        $prototypei.remove();
        e.preventDefault();
        return false;
      });
    }
  });
  
////////////////////////////////////////////////////////

      $(document).ready(function() {
    var $containero = $('div#cv_competences');
    var indexo = $containero.find(':input').length;
    $('#add_competences').click(function(e) {
      addCategoryo($containero);
      e.preventDefault();
      return false;
    });
    
     if (indexo == 0) {
      addCategoryo($containero);
    } else {
      $containero.children('div').each(function() {
        addDeleteLinko($(this));
      });
    }
    function addCategoryo($containero) {
      var templateo = $containero.attr('data-prototype')
        .replace(/__name__label__/g, 'Compétence n°' + (indexo+1))
        .replace(/__name__/g,        indexo)
      ;
      var $prototypeo = $(templateo);
      addDeleteLinko($prototypeo);
      $containero.append($prototypeo);
      indexo++;
    }
    function addDeleteLinko($prototypeo) {
      var $deleteLinko = $('<br><a href="#" class="btn btn-danger">Supprimer</a>');
      $prototypeo.append($deleteLinko);
      $deleteLinko.click(function(e) {
        $prototypeo.remove();
        e.preventDefault();
        return false;
      });
    }
  });


  
////////////////////////////////////////////////////////////////////

        $(document).ready(function() {
   var $containere = $('div#cv_langues');
     var indexe = $containere.find(':input').length;
    $('#add_langues').click(function(e) {
      addFichier($containere);
      e.preventDefault();
      return false;
    });

     if (indexe == 0) {
      addFichier($containere);
    } else {
      $containere.children('div').each(function() {
        addDeleteFile($(this));
      });
    }
    function addFichier($containere) {
      var template1 = $containere.attr('data-prototype')
       .replace(/__name__label__/g, 'Langues n°' + (indexe+1))
        .replace(/__name__/g,        indexe)
      ;
       var $prototype1 = $(template1);
     addDeleteFile($prototype1);
      $containere.append($prototype1);
      indexe++;
    }
    function addDeleteFile($prototype1) {
      var $deleteLink1 = $('<a href="#" class="btn btn-danger">Supprimer</a><br><br>');
      $prototype1.append($deleteLink1);
      $deleteLink1.click(function(e) {
        $prototype1.remove();
        e.preventDefault(); 
        return false;
      });
    }
  });
