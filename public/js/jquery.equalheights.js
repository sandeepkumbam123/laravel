!function($){$.fn.equalHeights=function(options){var maxHeight=0,$this=$(this),equalHeightsFn=function(){var height=$(this).innerHeight();height>maxHeight&&(maxHeight=height)};if(options=options||{},$this.each(equalHeightsFn),!options.wait)return $this.css("min-height",maxHeight);var loop=setInterval(function(){return maxHeight>0?(clearInterval(loop),$this.css("min-height",maxHeight)):void $this.each(equalHeightsFn)},100)},$("[data-equal]").each(function(){var $this=$(this),target=$this.data("equal");$this.find(target).equalHeights()})}(jQuery);