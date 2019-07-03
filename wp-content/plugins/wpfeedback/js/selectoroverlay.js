/**
 * This object encapsulates the elements and actions of the overlay.
 */
function Overlay(width, height, left, top) {
    this.width = this.height = this.left = this.top = 0;
  
    // outer parent
    var outer = jQuery("<div class='outer' />").appendTo("body");
    
    // red lines (boxes)
    var topbox    = jQuery("<div />").css("height", 1).appendTo(outer);
    var bottombox = jQuery("<div />").css("height", 1).appendTo(outer);  
    var leftbox   = jQuery("<div />").css("width",  1).appendTo(outer);
    var rightbox  = jQuery("<div />").css("width",  1).appendTo(outer);
  
    // don't count it as a real element
    outer.mouseover(function(){ 
        outer.hide(); 
    });
  
  
    /**
     * Public interface
     */
  
    this.resize = function resize(width, height, left, top) {
      if (width != null)
        this.width = width;
      if (height != null)
        this.height = height;
      if (left != null)
        this.left = left;
      if (top != null)
        this.top = top;      
    };
 
    this.show = function show() {
       outer.show();
    };
             
    this.hide = function hide() {
       outer.hide();
    };     

    this.render = function render(width, height, left, top) {
        
        this.resize(width, height, left, top);

        topbox.css({
          top:   this.top,
          left:  this.left,
          width: this.width
        });
        bottombox.css({
          top:   this.top + this.height - 1,
          left:  this.left,
          width: this.width
        });
        leftbox.css({
          top:    this.top, 
          left:   this.left, 
          height: this.height
        });
        rightbox.css({
          top:    this.top, 
          left:   this.left + this.width - 1, 
          height: this.height  
        });
          
        this.show();
    };      

    // initial rendering [optional]
    this.render(width, height, left, top);
}