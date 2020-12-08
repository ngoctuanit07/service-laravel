<html>
<head>
    <title>Tính cước giao hàng tiết kiệm</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="containner">
    <div class="row">
        <div class="col-sm-6 col-md-8">
            <form>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tinh">Tỉnh</label>
                        <input type="text" class="form-control" id="tinh"  placeholder="Vui lòng nhập tỉnh">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="huyen">Quận/Huyện</label>
                        <input type="text" class="form-control" id="huyen"  placeholder="Vui lòng nhập quận huyện">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="diachi">Địa chỉ</label>
                        <input type="text" class="form-control" id="diachi" placeholder="Vui lòng nhập địa chỉ">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="cannang">Cân nặng gói hàng(g):</label>
                        <input type="number" class="form-control" id="cannang" aria-describedby="cannang" placeholder="Vui lòng nhập cân nặng">
                        <small id="cannang" class="form-text text-muted">Có thể truy cập : https://www.rapidtables.com/convert/weight/kg-to-gram.html để lấy số gam của đơn hàng</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <p class="text-left">Giá cước:</p><p class="text-left">100000</p>
                    <button type="submit" class="btn btn-primary">Tính cước</button>
                </div>

            </form>
        </div>
    </div>
</div>
</body>
</html>
