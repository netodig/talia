// JavaScript Document//incluye esta clase en un fichero js,esto muestra la imgen... al seleccionarla		
var CartaFile = {
    file: '',
    dropbox: '',
    idTextEmptyDropBox: '',
    idContentParentImage: '',
    Initialize: function (params)
    {
        this.file = params.file;
        this.dropbox = params.dropbox;
        this.idTextEmptyDropBox = params.idTextEmptyDropBox;
        this.idContentParentImage = params.idContentParentImage;
		
		return jQuery.extend(true, {}, this);
	
    },
    createImage: function () {
        jQuery('#' + this.idTextEmptyDropBox);
        //var preview = $(template), 
        var preview = jQuery('#' + this.idContentParentImage);
        //preview.empty();
        var image = jQuery('img', preview);

        var reader = new FileReader();

        reader.onload = function (e) {
            image.show();
            image.attr('src', e.target.result);
        };
        reader.readAsDataURL(this.file);
        preview.appendTo(this.dropbox);
        jQuery.data(this.file, preview);
        return this;
    },
    openFile: function (idctrl)
    {
        jQuery('#' + idctrl).on('click', function () {
	
            var $this = jQuery(this);
            var idtarget = $this.attr('data-idopenfile');
            if (typeof idtarget != "undefined")
            {
                jQuery('#' + idtarget).trigger('click').on('change', function (e) {

                    if (!e.target.files[0].type.match(/^image\//))
                        return;
                    var f = jQuery(this);
                    CartaFile.file = e.target.files[0];
                    CartaFile.createImage();
                });
            }
            return false;
        });
    },
	 openFileMult: function (idctrl,obj)
    {
        jQuery('#' + idctrl).on('click', function () {
	
            var $this = jQuery(this);
            var idtarget = $this.attr('data-idopenfile');
            if (typeof idtarget != "undefined")
            {
                jQuery('#' + idtarget).trigger('click').on('change', function (e) {

                    if (!e.target.files[0].type.match(/^image\//))
                        return;
                    var f = jQuery(this);
                    obj.file = e.target.files[0];
                    obj.createImage();
                });
            }
            return false;
        });
    },
	openFile2: function (idctrl)
    {
        jQuery('#' + idctrl).on('click', function () {
	
            var $this = jQuery(this);
            var idtarget = $this.attr('data-idopenfile');
            if (typeof idtarget != "undefined")
            {
                jQuery('#' + idtarget).trigger('click').on('change', function (e) {

                    if (!e.target.files[0].type.match(/^image\//))
                        return;
                    var f = jQuery(this);
                    CartaFile.file = e.target.files[0];
                    CartaFile.createImage();
			
					$('#formfotos').submit();
                });
            }
            return false;
        });
    }

};