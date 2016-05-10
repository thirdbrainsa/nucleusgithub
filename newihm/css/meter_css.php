#countdown-wrap {
  width: 100%;
  height: 100px;
  //border: 1px solid black;
  padding: 20px;
  font-family: arial;
}

#goal {
  font-size: 48px;
  text-align: right;
  width: 80%;
  @media only screen and (max-width : 640px) {
    text-align: center;  
  }
  
}

#glass {
  width: 80%;
  height: 20px;
  background: #c7c7c7;
  border-radius: 10px;
  float: left;
  overflow: hidden;
}

#progress {
  float: left;
  width: <?php echo $_GET['pourc'];?>%;
  height: 20px;
  background: #AB2430;
  z-index: 333;
  //border-radius: 5px;
}

.goal-stat {
  width: 20%;
  height: 30px;
  padding: 10px;
  float: left;
  margin: 0;
  
  @media only screen and (max-width : 640px) {
    width: 40%;
    text-align: center;
  }
}

.goal-number, .goal-label {
  display: block;
}

.goal-number {
  font-weight: bold;
}