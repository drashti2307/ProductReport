<div style="padding:10px 10px 0;position:relative;">
    <div style="position:absolute;left:0;top:0px;">
        <img src="{{ 'data:image/' . pathinfo(public_path('image/image.png'), PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(public_path('image/image.png'))) }}" style="width: 130px;height:85px">
    </div>
    <h2>Weekly Product Report</h2>
    <div style="position:absolute;right:0;top:60px">
        Created: @php echo date('d-m-Y') @endphp
    </div>
</div>
<hr style=" border: none;
  height: 2px;
  background-color: #333;">
