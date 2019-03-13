<title>Christian's Laboratory</title>
<head>

  <!-- currently in root/usr/local/lib/node_modules/honeycomb-grid -->
  <script type="text/javascript" src="../resources/hex.js"> </script>
  <script type="text/javascript" src="/usr/local/lib/node_modules/npm/node_modules/honeycomb-grid/src/honeycomb.js"> </script>
  <script type="text/javascript" src="/usr/local/lib/node_modules/npm/node_modules/svg.js/src/svg.js"> </script>

  <div class="page_header floating_element">
    <span class="floating_element">
      This is where the fun begins
    </span>
  </div>
</head>
<body>
  <div class="Hex testing">
    Please make a hex map

    <script>
      const Grid = Honeycomb.defineGrid()
      Grid.rectangle({ width: 4, height: 4 })
    </script>

  </div>
</body>
