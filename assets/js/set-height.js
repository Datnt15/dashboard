;( function(document, window) {
    'use strict';
    //var s = document.body || document.documentElement, s = s.style;
    //if( s.webkitFlexWrap == '' || s.msFlexWrap == '' || s.flexWrap == '' ) return true;

    var _list = document.querySelectorAll('.list');
    var getHeight = function(_items){
        var maxHeight = 0;
        for (var i = 0; i < _items.length; i++) {
            if (_items[i].nodeName!= '#text') {
                maxHeight = (maxHeight > _items[i].clientHeight) ? maxHeight : _items[i].clientHeight;
            }
        }
        return maxHeight;
    };

    
    var setHeights = function(_items){
        var _height = getHeight(_items);
        for (var i = 0; i < _items.length; i++) {
            if (_items[i].nodeName!= '#text') {
                _items[i].setAttribute("style", "height:" + _height+ "px !important;");
            }
        }
    };
    

    var setDefaultHeights = function(_items){
        for (var i = 0; i < _items.length; i++) {
            if (_items[i].nodeName!= '#text') {
                _items[i].setAttribute("style", "height:auto;");
            }
        }
    };
    function setAllItemsHeight(_list){

        for (var i = 0; i < _list.length; i++) {
            var _row = _list[i].childNodes;
            var item_width = _row[0].nodeName != '#text' ? _row[0].clientWidth : _row[1].clientWidth;
            var per_row = Math.floor( _list[i].clientWidth / item_width );
            var _rows = []; // Will hold the array of Node's
            for(var j = _row.length; j--;){
                if (_row[j].nodeName!= '#text') {
                    _rows.unshift(_row[j]);
                }
            }
            for (var j = 0; j < _rows.length; j+= per_row) {
                var _items = _rows.slice(j, j+per_row);
                setDefaultHeights(_items);
                setHeights(_items);
            }
        }
    }

    setAllItemsHeight(_list);
    window.onresize = function(){
        setAllItemsHeight(_list);
    };
 
})(document, window);