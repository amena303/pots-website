/*!
 * Quz jQuery Plugin
 * http://github.com/drmartin/quz
 *
 * @author Daniel Reyes - http://www.drmart.in
 * @copyright (c) 2013 Pliskin - http://www.grupointeractivo.us
 * @license MIT
 */

;(function($, window, undefined){
    //-- Objeto
    var Quz = function(ele, opc) {
        //--
        this.ele  = ele;
        this.$el = $(ele);
        //-- 
        if(this.ini) {
            this.ini(opc);
        }
    }
    //-- Agregando métodos al objeto
    Quz.prototype = {
        //-- 
        def : {
              randQ : false
            , randA : false
            , ctlPrev : '.ctlPrev'
            , ctlNext : '.ctlNext'
            , itemWidth : 100
            , itemHeight : 100
            , lim : 3
            , repeat : false
        }
        //-- 
        , ini : function(opc) {

            //-- 
            var tht = this;
            var err = '';

            //-- Configuración
            this.cfg = $.extend({}, this.def, opc);


            //-- 
            //-- ELEMENTOS
            //-- 


            //-- UL (lista)
            this.$ul = this.$el.find('ul');
            //console.log(this.$ul);

            //-- UL (hijos)
            this.$li = this.$ul.children();
            //console.log(this.$li);

            //-- Padre
            this.$pa = this.$ul.parent();


            //-- 
            //-- VALORES
            //--


            //-- UL (hijos) - Límite
            this.lim = this.$li.length;
            console.log( 'BLOQUES NO VISIBLE - LIM: ' + this.lim);

            //-- UL (hijos) - Ancho
            this.wdt = ( this.lim * this.cfg.itemWidth );
            console.log( 'BLOQUES NO VISIBLE - WDT: ' + this.wdt);

            //-- SI Visible - Ancho
            //this.itemWidth = this.$li.outerWidth(true);
            this.visWdt = this.cfg.lim * this.cfg.itemWidth;
            console.log( 'BLOQUES SI VISIBLE - WDT: ' + this.visWdt);

            //-- SI Visible - Límite
            //this.visLim = Math.floor(this.$pa.width() / this.itemWidth);
            this.visLim = this.cfg.lim;
            console.log( 'BLOQUES SI VISIBLE - LIM: ' + this.visLim);

            //-- SI Visible - Elementos Agregar
            //this.limRes = Math.floor(this.lim/this.visLim) + this.visLim;
            this.limRes = this.visLim;
            console.log('BLOQUES SI VISIBLE - RES: ' + this.limRes );

            //-- Actualiza límite
            //this.lim += this.limRes;

            //-- BLOQUE - WDT
            console.log( 'BLOQUE - WDT: ' + this.cfg.itemWidth);
            //-- BLOQUE - LIM
            console.log( 'BLOQUE - LIM: ' + this.cfg.lim);


            //-- 
            //console.log('ATTR: ' + this.$pa.attr('class'));
            //console.log(this.$pa);


            //-- 
            if (this.cfg.lim > this.lim) {
                err += 'El parámetro \'lim\' = '+this.cfg.lim+', es mayor a la cantidad de elementos existentes \''+this.lim+'\'';
            }

            if (err != '') {
                //-- Damos un error
                $.error(err);
                if (typeof console != 'undefined') {
                    console.warn(err);
                } 
                else {
                    window.alert(err);
                }
            }


            //-- 
            //-- SET
            //--


            // //-- PREV
            // $(this.cfg.ctlPrev).css({
            //       //'width'  : (this.cfg.itemWidth/3) + 'px'
            //     , 'height' : ( this.cfg.itemHeight ) + 'px'
            //     , 'line-height' : ( this.cfg.itemHeight ) + 'px'
            // });

            // //-- NEXT
            // $(this.cfg.ctlNext).css({
            //       'width'  : (this.cfg.itemWidth/3) + 'px'
            //     , 'height' : ( this.cfg.itemHeight ) + 'px'
            //     , 'line-height' : ( this.cfg.itemHeight ) + 'px'
            // });

            console.log(this.cfg.ctlPrev+' '+$(this.cfg.ctlPrev).outerWidth(true));
            console.log( ( $(this.cfg.ctlPrev).width(true) + $(this.cfg.ctlNext).width(true) ) + 'px');

            //-- SI Visible
            this.$el.css({
                  'width'  : ( this.visWdt ) + 
                  ( $(this.cfg.ctlPrev).outerWidth(true) + $(this.cfg.ctlNext).outerWidth(true) ) + 'px'
                , 'height' : ( this.cfg.itemHeight ) + 'px'
            });

            //-- SI Visible
            this.$pa.css({
                  'width'  : ( this.visWdt ) + 'px'
                , 'height' : ( this.cfg.itemHeight ) + 'px'
            });

            //-- NO Visible - Dimensiones
            this.$ul.css({
                'width' :  ((this.lim) * this.cfg.itemWidth) + 
                (this.cfg.repeat ? this.cfg.itemWidth*this.limRes : 0 ) + 'px'
            });

            //-- NO Visible - Dimensiones
            this.$li.css({
                  'width'  : ( this.cfg.itemWidth ) + 'px'
                , 'height' : ( this.cfg.itemHeight ) + 'px'
                //, 'line-height' : ( this.cfg.itemHeight ) + 'px'
            });

            //-- Status
            tht.sts = {
                  act : 1
                , mov : false
            };

            //-- Disparador
            $(this.cfg.ctlPrev).click(function(jel) {
                //-- 
                jel.preventDefault();
                //-- Evento
                tht.ctlPrev();
            });

            //-- Disparador
            $(this.cfg.ctlNext).click(function(jel) {
                //-- 
                jel.preventDefault();
                //-- 
                tht.ctlNext();
            });

            //-- 
            if(this.cfg.repeat){
                console.log('Agregando \''+this.limRes+'\' elementos');
                //-- Recorre elementos visibles necesarios y los agrega al final
                for(var i = 0; i < this.limRes ; i++) {
                    //-- 
                    var tmp = this.$li.eq(i).clone();
                    //-- 
                    this.$ul.append(tmp);
                };

            }

            //-- Ver primer elemento
            this.show(1);
        }
        , show : function(idx) {
            console.log('idx: '+idx);
            //-- 
            $el = this.$ul;
            //-- 
            idx_sig = this.set($el, idx);
            //console.info('SIG IDX: '+idx_sig);
            //-- 
            this.ani($el, idx_sig);
        }
        , set : function($el, idx) {
            // //-- 
            // console.info('-DATA-');
            // console.log('idx: ' + idx);
            // console.log('act: ' + this.sts.act);
            // console.log('lim: ' + this.lim );
            //-- 
            var dir = (this.sts.act - idx) <= 0 ? "-" : "+";
            dir = this.sts.act == idx ? '' : dir;
            //console.log('dir: ' + dir);

            //--
            idx_sig = idx;

            //--
            if(this.cfg.repeat == false){
                switch(dir){
                    case '+':
                        //-- 
                        console.info('-LIMITE -> IZQ-');
                        //-- 
                        console.log('act:'+this.sts.act+', sig:'+(this.sts.act-1)+', lim:'+(this.lim)+', vis:'+this.visLim);

                        //--
                        if( (this.sts.act-1) <= 0 ) {
                            console.log('->'+'Aumenta en uno.');
                            idx_sig += 1;
                        }
                        //-- 
                        //console.log('act:'+this.sts.act+', sig:'+(this.sts.act-1)+', lim:'+(this.lim)+', vis:'+this.visLim);
                        //-- 
                    break;
                    case '-':
                        //-- 
                        console.info('-LIMITE -> DER-');
                        //-- 
                        console.log('act:'+this.sts.act+', sig:'+(this.sts.act-1)+', lim:'+(this.lim)+', vis:'+this.visLim);
                        //-- 
                        console.log(
                            '(lim:' + (this.lim) + ')-(sig:' + (this.sts.act-1) + ') = ' + ((this.lim) - (this.sts.act-1)) + 
                            '\n' +
                            ((this.lim) - (this.sts.act-1)) + ' <= ' + this.visLim + ' = ' + (((this.lim) - (this.sts.act-1)) <= this.visLim) );

                        //-- 
                        if( (this.lim-(this.sts.act-1)) <= this.visLim ) {
                            console.log('->'+'Reduce en uno.');
                            idx_sig -= 1;
                        }
                    break;
                }
            }
            else {

                //--
                //console.log(''+idx+' > '+this.lim+' + '+'1 = ' + (idx > this.lim+1) ) ;

                //--
                if( idx > (this.lim + 1) ) {
                    //-- 
                    $el.css('left', '0px');
                    //-- 
                    this.sts.act = 1;
                    //-- 
                    idx_sig = 2;
                }

                //-- 
                //console.log(''+idx+' > '+this.lim+' + '+'1 = ' + (idx > this.lim+1) ) ;

                //-- 
                if(idx <= 0) {
                    //-- 
                    $el.css('left', (this.lim * this.cfg.itemWidth * -1) + 'px');
                    //-- 
                    idx_sig = this.lim;
                }
            }

            //-- 
            console.log('IDX SIG: '+idx_sig);
            return idx_sig;
        }
        //-- 
        , ani : function($el, idx) {
            //console.info('-DIR-')
            //console.log(''+this.sts.act+' - '+idx+' = ' + (this.sts.act - idx));
            //-- 
            //var dir = (this.sts.act - idx) <= 0 ? "-" : "+";
            //var dir = (this.visLim>this.sts.act) <= 0 ? "-" : "+";
            var dir = "-";

            //console.log('dir: ' + dir);
            //-- 
            //dir = this.sts.act == idx ? '' : dir;
            //console.log('dir: ' + dir);
            //-- 
            this.sts.mov = true;
            //-- 
            var tht = this;

            //-- 
            //console.log(dir+' '+(this.cfg.itemWidth*(idx-1)) );

            //-- 
            $el.animate({
                //-- 
                //left: dir + "=" + (this.cfg.itemWidth) + 'px',
                left: dir + (this.cfg.itemWidth)*(idx-1) + 'px',
            }
            , 'swing', function(){
                //-- 
                tht.sts.act = idx;
                tht.sts.mov = false;
                //-- 
                //tht.cfg.onQuzChange.apply(
                    //-- 
                    //tht.$ul.children().eq(idx - 1);
                //);
            });
        }
        , ctlNext: function() {
            //-- 
            if(!this.sts.mov) {
                //-- 
                //this.show(this.sts.act + this.visLim);
                this.show(this.sts.act + 1);
            }
        }
        , ctlPrev: function() {
            //-- 
            if(!this.sts.mov) {
                //-- 
                this.show(this.sts.act - 1);
            }
        }
    }

    //-- Plugin
    $.fn.quz = function(opc) {
        //-- Si se llama a algún metodo.
        if (typeof opc === 'string') {
            //-- Comando invocando
            cmd = opc;
            //-- Argumentos
            arg = Array.prototype.slice.call(arguments, 1);
            //-- Instancia previamente inicializada
            var quz = this.data('quz') ? this.data('quz') : new Quz(this);
            //-- Si existe el metodo
            if(quz[cmd]) {
                return quz[cmd].apply(quz, arg);    
            }
            //-- Si no existe
            else {
                //-- Damos un error
                $.error('Command '+cmd+' does not exist.');
            }
        }
        //-- Si no se llama a algún metodo
        else {
            //-- Objeto como parámetro
            if (typeof opc === 'object' || !opc) {
                //-- Retorna para el selector invocado
                return this.each(function() {
                    //-- Validando si ha sido inicializado
                    if (undefined == $(this).data('quz')) {
                        //-- Creamos una nueva instancia.
                        var quz = new Quz(this, opc);
                        //-- Agregamos la instancia al objeto jquery
                        $(this).data('quz', quz);
                    }
                });
            }
            else {
                $.error('Error, passed argument is not valid');
            }
        }
        //--
        return this;
    }
    //-- Soy solidario
    window.Quz = Quz;
})(jQuery, window);
