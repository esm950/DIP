
function Comment(commentStr, time, currLength, currHeight, fontType, fontSize, color) {
    this.commentStr = commentStr;
    this.time = time;
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
	//console.log("20pt "+this.fontType);
	//console.log(this.fontSize+"pt "+this.fontType);
	//return "20pt "+this.fontType;
	return this.fontSize+"pt "+this.fontType;
		
		
	}
	this.getComment = function(){
		return this.commentStr;
	}
	this.checkClicked = function(arrayC){
	//console.log("i clicked at "+arrayC[0]+","+arrayC[1]);
	//console.log("letter is at"+this.currLength+","+this.currHeight);
	var charLength = this.commentStr.length;
	
		if(arrayC[0] > this.currLength && arrayC[0] < this.currLength+charLength*this.fontSize)
		{

			if(arrayC[1] > this.currHeight && arrayC[1] < this.currHeight+this.fontSize){
			console.log(""+this.commentStr);
			return 0;
			}
		}else
		{return 1;}
		
	}
	
	}


