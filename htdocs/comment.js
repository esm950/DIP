
function Comment(commentStr, time, anno, currLength, currHeight, fontType, fontSize, color) {
    this.commentStr = commentStr;
    this.time = time;
    this.anno = anno;
    this.currHeight = currHeight;
    this.currLength = currLength;
    this.fontType = fontType;
    this.fontSize = fontSize;
    this.color = color;
	
	this.move = function(speed){
		this.currLength = this.currLength - speed;

	}
	
	this.getLength = function(){
		return this.currLength;
	}
	
	this.setHeight = function(height){
		this.currHeight = height;
	}
	
	this.getHeight = function(){
		return this.currHeight;
		
	}
	
	this.getColor = function(){
		return this.color;
		
	}
	this.getFontType = function(){
		return this.fontType;
		
	}
	this.getFont = function(){
	return this.fontSize+"pt "+this.fontType;
		
		
	}
	this.getComment = function(){
		return this.commentStr;
	}
	
		this.isAnno = function(){
		return this.anno;
	}
	
	this.getPixelLength = function(){	//Length of comment in pixel
		var charLength = this.commentStr.length;
		console.log(charLength);
		return charLength*this.fontSize*70/100;
		
	}
	
	this.getPixelHeight = function(){	//Height of comment in pixel
		return this.fontSize;
	}
	
	
	this.checkClicked = function(arrayC){
	var charLength = this.commentStr.length;
	
		if(arrayC[0] > this.currLength && arrayC[0] < this.currLength+this.getPixelLength())
		{

			if(arrayC[1] > this.currHeight && arrayC[1] < this.currHeight+this.getPixelHeight()){
			//console.log(""+this.commentStr);
			if(this.anno == 1){		//check if it is annotation
			return 0;
			}
			else
			{
				console.log(this.commentStr+" is not an anno");
			}
			}
		}else
		{return 1;}
		
	}
	
	
	}

