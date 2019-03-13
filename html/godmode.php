<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<title>God Mode</title>
</head>


<body>
  <h1> God Mode - Where Your Dreams Can Come True</h1>
  <hr>

  <!-- Try using an aside tag to create a vert line -->

  <a>Select the nation whose values you want to alter</a>

<!-- Need to specify action type -->
  <form class="form">
    <input type="radio" name="nation" value="Taiga" checked> Taiga<br>
    <input type="radio" name="nation" value="Boreala"> Boreala<br>
    <input type="radio" name="nation" value="The Highlands"> The Highlands<br>
    <input type="radio" name="nation" value="Archipelagia"> Archipelagia<br>
    <input type="radio" name="nation" value="The League"> The League<br>
    <input type="radio" name="nation" value="Riparia"> Riparia<br>
    <input type="radio" name="nation" value="Arborea"> Arborea<br>
    <input type="radio" name="nation" value="Desicca"> Desicca<br>
    <input type="submit" value="Submit">
  </form>

  <br>

  <form>
    Input Economy modification:<br>
    <input type="number" name="economy"><br>
    Input Military modification:<br>
    <input type="number" name="military"><br>
    Input Public Opinion modification:<br>
    <input type="number" name="public_op"><br>
    Input Fish modification:<br>
    <input type="number" name="fish"><br>
    Input Oil modification:<br>
    <input type="number" name="oil"><br>
    Input Minerals modification:<br>
    <input type="number" name="minerals"><br>
    Input Uranium modification:<br>
    <input type="number" name="uranium">
  </form>

</body>
