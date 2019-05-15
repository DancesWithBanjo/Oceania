


<!-- <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'>
<path d='M12 0c-4.87 7.197-8 11.699-8 16.075 0 4.378 3.579 7.925 8 7.925s8-3.547 8-7.925c0-4.376-3.13-8.878-8-16.075z'/></svg> -->
<?php 
  $isGod = 0;
  $uName = $_SESSION["username"];
  if($uName == 'godmode'){
    $isGod = 1;
  }
?>

    <script>
    // Gets hex id from selected hex
    function getHexID(id, evt, message) {
        if (<?php echo $isGod ?>){
          document.getElementById("hexID").value = id;
        } else{
          var out, nat = "", oil = "", gas = "", fish = "", mount = "", coal = "", cit = "", cap = "";
          var str = message.split("\n");
          str.forEach(function(line){
            var data = line.split(" ");
            // console.log(data[0]);
            // console.log(data[1]);
            switch (data[0]){
              case "Nation:":
                nat = data[0] + " " + data[1];
                break;
              case "Oil:":
                if (data[1] != "0"){
                  oil = "\n" + data[0] + " " + data[1];
                }
                break;
              case "Fish:":
                if (data[1] != "0"){
                  fish = "\n" + data[0].substring(0, data[0].length-1);
                }
                break;
              case "Gas:":
                if (data[1] != "0"){
                  gas = "\nNatural " + data[0] + " " + data[1];
                }
                break;
              case "Mountain:":
                if (data[1] != "0"){
                  mount = "\n" + data[0].substring(0, data[0].length-1);
                }
                break;
              case "Coal:":
                if (data[1] != "0"){
                  coal = "\n" + data[0].substring(0, data[0].length-1);
                }
                break;
              case "City:":
                if (data[1] != "0"){
                  cit = "\n" + data[0].substring(0, data[0].length-1);
                }
                break;
              case "Capital:":
                if (data[1] != "0"){
                  cap = "\n" + data[0].substring(0, data[0].length-1);
                }
                break;
              default:
                break;
            }
          });
          out = nat + oil + fish + gas + mount + coal + cit + cap;
          // console.log(nat);
          // console.log(oil);
          // console.log(fish);
          // console.log(gas);
          // console.log(mount);
          // console.log(coal);
          // console.log(cit);
          // console.log(cap);
          alert(out);
        }
    }
    //function notify(evt, message){alert(message)}
  </script>

<?php


  $result = mysqli_query($conn, "SELECT * FROM hexes;");

  echo "<div class='content_section floating_element'>";
  echo "<svg viewBox='0 0 1000 625'>";
  echo "<defs>";
  echo "<g id='pod'>";
  echo "<polygon stroke='#F5F5F5' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
  echo "</g>";
  echo "<g id='oilPod1'>";
  echo "<polygon stroke='#F5F5F5' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
  echo "<polygon stroke='black' stroke-width='4' points='0,4 0,-4'/>";
  //echo "<svg xmlns='http://www.w3.org/2000/svg' width='12' height='12'>";
  //echo "<path fill='transparent' stroke='#000' stroke-width='1.5'
  //  d='M15 3 Q16.5 6.8 25 18  A12.8 12.8 0 1 1 5 18 Q13.5 6.8 15 3z'/>";
  echo "</g>";

  echo "<g id='oilPod2'>";
  echo "<polygon stroke='#F5F5F5' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
  echo "<polygon stroke='black' stroke-width='3' points='-3,4 -3,-4'/>";
  echo "<polygon stroke='black' stroke-width='3' points='3,4 3,-4'/>";
  echo "</g>";

  echo "<g id='oilPod3'>";
  echo "<polygon stroke='#F5F5F5' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
  echo "<polygon stroke='black' stroke-width='3' points='-3,-1 -3,-5'/>";
  echo "<polygon stroke='black' stroke-width='3' points='3,-1 3,-5'/>";
  echo "<polygon stroke='black' stroke-width='3' points='0,1 0,5'/>";
  echo "</g>";

  echo "<g id='fish'>";
  echo "<polygon stroke='#F5F5F5' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
  //echo "<polygon stroke='black' fill='black' stroke-width='1' points='0,5 -5,0 0,-5 5,0'/>";
  echo "<polygon stroke='black' fill='black' stroke-width='1' points='8,0 3,-5 -2,0 3,5'/>";
  echo "<polygon stroke='black' fill='black' stroke-width='1' points='-2,0 -5,-4 -5,4'/>";
  // 3,0 5,-4 5,4
  echo "</g>";

  echo "<g id='mountain'>";
  echo "<polygon stroke='#F5F5F5' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
  echo "<polygon stroke='black' stroke-width='1' points='-3,5 7,5 2,-5'/>";
  echo "<polygon stroke='black' stroke-width='1' points='-2,3 -4,3 0,-5 1,-3'/>";
  echo "<polygon stroke='black' stroke-width='1' points='-3,1 -5,1 -2,-5 -1,-3'/>";
  echo "</g>";

  echo "<g id='city'>";
  echo "<polygon stroke='#F5F5F5' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
  echo "<polygon stroke='black' fill='black' stroke-width='1' points='0,4 -4,0 0,-4 4,0'/>";
  echo "</g>";

  echo "<g id='capital'>";
  echo "<polygon stroke='#F5F5F5' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
  echo "<polygon stroke='black' fill='black' stroke-width='1' points='0,-7 2,-2 6,-2 3,1 4,6 0,3 -4,6 -3,1 -6,-2 -2,-2'\>";
  echo "</g>";

  echo "<g id='coal'>";
  echo "<polygon stroke='#F5F5F5' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
  echo "<polygon stroke='black' stroke-width='1' points='-3,5 7,5 2,-5'/>";
  echo "<polygon stroke='black' stroke-width='1' points='-2,3 -4,3 0,-5 1,-3'/>";
  echo "<polygon stroke='black' stroke-width='1' points='-3,1 -5,1 -2,-5 -1,-3'/>";
  echo "<polygon stroke='black' fill='black' stroke-width='1' points='2,3 1,1 2,-1 3,1'\>";
  echo "<polygon stroke='black' fill='black' stroke-width='1' points='-7,1 -8,3 -7,5 -6,3'\>";
  //echo "<polygon stroke='black' stroke-width='1' points='6,3 7,5 8,3 7,1'\>";
  echo "</g>";

  echo "<g id='gas1'>";
  echo "<polygon stroke='#F5F5F5' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
  echo "<polygon stroke='white' stroke-width='4' points='0,4 0,-4'/>";
  echo "</g>";

  echo "<g id='gas2'>";
  echo "<polygon stroke='#F5F5F5' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
  echo "<polygon stroke='white' stroke-width='3' points='-3,4 -3,-4'/>";
  echo "<polygon stroke='white' stroke-width='3' points='3,4 3,-4'/>";
  echo "</g>";

  echo "<g id='gas3'>";
  echo "<polygon stroke='#F5F5F5' stroke-width='1' points='-9,5 -9,-5 0,-10 9,-5 9,5 0,10'/>";
  echo "<polygon stroke='white' stroke-width='3' points='-3,-1 -3,-5'/>";
  echo "<polygon stroke='white' stroke-width='3' points='3,-1 3,-5'/>";
  echo "<polygon stroke='white' stroke-width='3' points='0,1 0,5'/>";
  echo "</g>";

  echo "</defs>";


  //echo "     <g id='border'>";
  //echo "        <ellipse cx='200' cy='80' rx='100' ry='50' style='fill:yellow;stroke:purple;stroke-width:2' />";
  //echo "     </g>";
  echo "<g class='pod-wrap'>";

  $ystart = 15;
  $xstart = 10;
  $xind = 0;

 // $result = mysqli_query($conn, "SELECT * FROM hexes");
  while ($row = mysqli_fetch_assoc($result))
  {
    if($xind == 55)
    {
      if($xstart == 1000)
      {
        $xstart = 18.5;
      }
      else
      {
        $xstart = 10;
      }
      $xind =0;
      $ystart = $ystart + 15;
    }

    if($row["state"] == 'ocean')
    {
      $color = "#d2fff7";
    }
    if($row["state"] == 'ice')
    {
      $color = "#ffffff";
    }
    if($row["state"] == 'Taiga')
    {
      $color = "#92c4d1";
    }
    if($row["state"] == 'Boreala')
    {
      $color = "#ecbf84";
    }
    if($row["state"] == 'Highlands')
    {
      $color = "#96a2e8";
    }
    if($row["state"] == 'Archipelagia')
    {
      $color = "#ef81cb";
    }
  	if($row["state"] == 'Riparia')
    {
      $color = "#d9d3ea";
    }
    if($row["state"] == 'League')
    {
      $color = "#e8fa8c";
    }
    if($row["state"] == 'Desicca')
    {
      $color = "#d1bc8b";
    }
    if($row["state"] == 'frozen isles')
    {
      $color = "#e8e5e7";
    }
    if($row["state"] == 'Arborea')
    {
      $color = "#75d59d";
    }
    if($row["numOil"] == 0)
    {
      $tile = '#pod';
    }
    if($row["numOil"] == 1)
    {
      $tile = '#oilPod1';
    }
    if($row["numOil"] == 2)
    {
      $tile = '#oilPod2';
    }
    if($row["numOil"] == 3)
    {
      $tile = '#oilPod3';
    }
    if($row["numFish"] == 1)
    {
      $tile = '#fish';
    }
    if($row["coal"] == 1)
    {
      $tile = '#coal';
    }
    if($row["nGas"] == 1)
    {
      $tile = '#gas1';
    }
    if($row["nGas"] == 2)
    {
      $tile = '#gas2';
    }
    if($row["nGas"] == 3)
    {
      $tile = '#gas3';
    }
    if($row["mountains"] == 1)
    {
      $tile = '#mountain';
    }
    if($row["city"] == 1)
    {
      $tile = '#city';
    }
    if($row["capital"] == 1){
      $tile = '#capital';
    }

    //echo "  <use xlink:href='#pod' transform='translate($xstart, $ystart)' style='fill: $color'/>" ;
    $hid = $row["hexID"];
    echo "  <use xlink:href=$tile transform='translate($xstart, $ystart)' onclick='getHexID($hid, evt, \"Nation: $row[state] \\nOil: $row[numOil] \\nFish: $row[numFish] \\nCoal: $row[coal] \\nGas: $row[nGas] \\nMountain: $row[mountains] \\nCity: $row[city] \\nCapital: $row[capital] \")' style='fill: $color'/>" ;
    $xstart = $xstart + 18;
    $xind = $xind +1;

  }
  echo "</g>";
  echo "</svg>";
  echo "</div class='content_section_text'>";
  ?>
