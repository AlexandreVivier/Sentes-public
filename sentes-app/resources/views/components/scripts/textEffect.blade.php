
<script>
    var i = 0;
var text = "les Sentes.";
function typing(){
  if (i < text.length)
    {
      document.getElementById("textEffect").innerHTML+=text.charAt(i);
      i++;
      setTimeout(typing, 200);

    }
}
typing();

</script>


