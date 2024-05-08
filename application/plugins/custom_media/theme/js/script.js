var SELECTION_RECT = (function(){
    cntrlIsPressed = false;
    var elements = [];
    var rectangleSelect = function(inputElements, selectionRectangle) {
        inputElements.forEach(function(element) {
            var box = element.getBoundingClientRect();
            var result = doObjectsCollide(getSelectionRectNode(),element);
            if(result == true){
                elements.push(element);
            }
        });
        return elements;
    } 
    var doObjectsCollide = function(a, b) { 
        var aTop = a.offsetTop;
        var aLeft = a.offsetLeft;
        var bTop = b.offsetTop;
        var bLeft = b.offsetLeft;
        return !(
            ((aTop + a.offsetHeight) < (bTop)) ||
            (aTop > (bTop + b.offsetHeight)) ||
            (aLeft + a.offsetWidth < bLeft) ||
            (aLeft > (bLeft + b.offsetWidth))
        );
    }  
    var getSelectionRectNode = function() {
        return document.querySelector(".selection-rect");
    }
    var hideSelectionRectangle = function() {
        var rect = getSelectionRectNode();
        rect.style.opacity = 0;
    }
    var selectBoxes = function(selection) {
        var dis = euclideDistance(selection);
        if(dis<50)return;
        deselectBoxes();
        var arr = [];
        rectangleSelect(getBoxes(), selection).forEach(function(box) {
            var mdi = box.querySelector('.mdi-img');
            mdi.classList.add("fileSelected");
            var checkbox = box.querySelector('.selectfile');
            checkbox.checked = true;
            arr.push(checkbox);
            
        });
        addValueListFileSelected(arr);
    }
    var euclideDistance = function(selection){
        return Math.sqrt(Math.abs(Math.pow((selection.firstX-selection.lastX),2)) + Math.abs(Math.pow((selection.firstY-selection.lastY),2)));
    }
    var deselectBoxes = function(e) {
        if(e){
            var clear = false;
            var paths = e.path;
            for(var i =0; i< paths.length;i++ ){
                var path = paths[i];
                if(path.innerText =='Apply' || path.innerText =='Delete'){
                    clear = false;
                    break;
                }
                if(path.id =='media-manage'){
                    clear = true;
                    break;
                }
            }
            if(!clear) return;
        }
        if(cntrlIsPressed) return;
        getBoxes().forEach(function(box) {
            var mdi = box.querySelector('.mdi-img');
            mdi.classList.remove("fileSelected");
            var checkbox = box.querySelector('.selectfile');
            checkbox.checked = false;
        });
        removeValueListFileSelected();
    }
    var addValueListFileSelected = function(arr){
        var objs = [];
        for (var i = 0; i < arr.length; i++) {
            var value = arr[i].value;
            objs.push(value);
        }
        document.querySelector('input[name=listselected]').value = JSON.stringify(objs);
    }
    var removeValueArrayElements = function(){
        elements = [];
    }
    var removeValueListFileSelected = function(){
        removeValueArrayElements();
        document.querySelector('input[name=listselected]').value = '';
    }
    var getBoxes = function() {
        return [...document.querySelectorAll(".file.fileitem")];
    }
    var initEventHandlers = function() {
        var isMouseDown = false;
        var mouseMove = false;
        var rectangle = {
            firstX: 0,
            firstY: 0,
            lastX: 0,
            lastY: 0
        };
        function onMouseDown(e) {
            isMouseDown = true;
            deselectBoxes(e);
            rectangle.firstX = e.clientX;
            rectangle.firstY = e.clientY;
        }
        function onMouseMove(e) {
            mouseMove = false;
            if (!isMouseDown) {
                return;
            }
            mouseMove = true;
            var x = e.clientX;
            var y = e.clientY;
            rectangle.lastX = x;
            rectangle.lastY = y;
            selectBoxes(rectangle);
            var top = 0;
            var left = 0;
            if (rectangle.lastX < rectangle.firstX && rectangle.lastY < rectangle.firstY) {
                top = rectangle.lastY;
                left = rectangle.lastX;
            } else if (rectangle.lastX < rectangle.firstX && rectangle.lastY > rectangle.firstY) {
                top = rectangle.firstY;
                left = rectangle.lastX;
            } else if (rectangle.lastX > rectangle.firstX && rectangle.lastY > rectangle.firstY) {
                top = rectangle.firstY;
                left = rectangle.firstX;
            } else {
                top = rectangle.lastY;
                left = rectangle.firstX;
            }
            var rect = getSelectionRectNode();
            rect.style.left = `${left}px`;
            rect.style.top = `${top + window.scrollY}px`;
            rect.style.width = `${Math.abs(rectangle.lastX - rectangle.firstX)}px`;
            rect.style.height = `${Math.abs(rectangle.lastY - rectangle.firstY)}px`;
            rect.style.opacity = 0.5; 
        }
        function onMouseUp(e) {
            isMouseDown = false;
            if(mouseMove==true){
                selectBoxes(rectangle);
            }
            else{
                deselectBoxes(e);
            }
            hideSelectionRectangle();
            rectangle = {
                firstX: 0,
                firstY: 0,
                lastX: 0,
                lastY: 0
            };
           
        }
        document.addEventListener("mousedown", onMouseDown);
        document.addEventListener("mousemove", onMouseMove);
        document.addEventListener("mouseup", onMouseUp);
    }
    var initCtrShiftChooseFile = function(){
        var lastChecked = null;
        var itemFile = document.querySelectorAll('.mdi-img');
        $(document).on('click','.mdi-img',function(e){
            if (e.ctrlKey  &&  e.shiftKey) {
                console.log(1);
            }
            if (e.altKey) {
                var filter   = Array.prototype.filter;
                var result   = document.querySelectorAll('div');
                var filtered = filter.call( result, function( node ) {
                    return !!node.querySelectorAll('span').length;
                });
                console.log(filtered);
                itemFile.filter(':not(:disabled)')
                .each(function() {
                    var checkbox = $(this);
                    checkbox.prop('checked', !checkbox.is(':checked'));
                });
            }
        });
        /*itemFile.click(function(e) {
            if (e.ctrlKey  &&  e.shiftKey) {
                var from = itemFile.index(this);
                var to = itemFile.index(this);
                var start = Math.min(from, to);
                var end = Math.max(from, to) + 1;
                itemFile.slice(start, end).filter(':not(:disabled)').prop('checked', lastChecked.checked);
            }
            lastChecked = this;
            
        });*/
    }
    var initCtrlKeyEvent = function(){
        $(document).keydown(function(e){
            if(e.which=="17")
                cntrlIsPressed = true;
        });
        $(document).keyup(function(){
            cntrlIsPressed = false;
        });
    }
    var dblClickApplyFile = function(){
        $(document).on('dblclick', '.mdi-img[rel="mdi"]', function(e) {
            e.preventDefault();
            this.classList.add('fileSelected');
            var checkbox = this.parentNode.parentNode.querySelector('.selectfile');
            elements.push(checkbox);
            addValueListFileSelected(elements);
            removeValueArrayElements();
            MediaManager.applyChooseImage();
        });
    }
    
    var init = function() {
        initEventHandlers();
        initCtrlKeyEvent();
        dblClickApplyFile();
        /*initCtrShiftChooseFile();*/
        
    }
    return{
        _:function(){
            
            init();
        }
    }
})();
SELECTION_RECT._();