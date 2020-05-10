@extends('admin.layouts.master')
@section("title","Dashboard")
@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <h2>Hướng dẫn cấu hình tool lấy dữ liệu</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-6 col-xs-12">
                <h2>Cấu hình wordpress</h2>
                <ul class="list-unstyled">
                    <li>Bước 1 : Cài đặt plugin jwt-authentication-for-wp-rest-api</li>
                        - Các bạn đăng nhập vô website mà các bạn đã thêm trên tool và cài đặt plugin jwt-authentication-for-wp-rest-api như hình sau 
                            <img src="https://live.staticflickr.com/65535/49876693998_34ef4ef19e_h.jpg" alt="{{ __('caidatplugin') }}" style="width: 95%;"/>
                    <li>Bước 2: Lấy Token của user admin với postman</li>
                        - Sau khi cài đặt xong plugin và active nó trên website của bạn , bước tiếp các bạn sử dụng postman để lấy token của user admin để sử dụng cho việc đồng bộ post từ tool về website của các bạn
                        <img src="https://live.staticflickr.com/65535/49877251111_422d53326e_b.jpg" alt="{{ __('laytoken') }}" style="width: 95%;"/>

                    <li>Bước 3: Cập nhật nó trên website<br/>
                        - Sau khi có token xong , các bạn cập nhật thông tin lên tool gồm :<br/>
                            + Địa chỉ website<br/>
                            + Token user thực hiện ở bước trên <br/>
                             <img src="https://live.staticflickr.com/65535/49876834043_d1e002b1f2_h.jpg" alt="{{ __('capnhatthongtin') }}" style="width: 95%;"/>
                    </li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-6 col-xs-12">
                <h2>Lấy data trên tool</h2>
                <ul class="list-unstyled">
                    <li>Bước 1 : Tạo mới link cần lấy dữ liệu</li>
                        + Đầu tiên các bạn truy cập link menu Craw => List data
                        + Tạo một link mới 
                         <img src="https://live.staticflickr.com/65535/49877384981_cc45c44f41_h.jpg" alt="{{ __('capnhatthongtin') }}" style="width: 95%;"/>
                         ở đây các bạn đưa link cần lấy dữ liệu lên tool, sau đó cập nhật các thông số cài đặt để tool có thể lấy dữ liệu gồm : class bao nội dung, class title, class content, class lấy image đầu tiên làm hình ảnh featured.
                         Các bạn chưa biết có thể kết bạn zallo số : 0976522437 để mình hỗ trợ
                    <li>Bước 2: Đồng bộ nó với website wordpress
                        + Sau khi tool lấy xong dữ liệu , nó sẽ hiển thị như hình bên dưới các bạn bấm vào button Sync wordpress để tiến hành đồng bộ data lên website wordpress
                         <img src="https://live.staticflickr.com/65535/49877395716_26839686f3_h.jpg" alt="{{ __('capnhatthongtin') }}" style="width: 95%;"/>
                    </li>
                    <li>Bước 3: Xem kết quả
                        + Sau khi tool đồng bộ xong data , các bạn có thể đăng nhập website wordpress của mình để xem kết quả đã đồng bộ  ở đây mình sẽ để trạng thái của post là draft và danh mục mặc định của wordpress khi cài đặt để các bạn có thể vô chỉnh sửa theo nghiệp vụ riêng của website
                         <img src="https://live.staticflickr.com/65535/49877706372_20c753c65f_h.jpg" alt="{{ __('capnhatthongtin') }}" style="width: 95%;"/>
                    </li>
                </ul>
            </div>
            <!-- ./col -->
        </div>
        <p>Lời cuối : Rất mong nhận được sử ủng hộ và đóng góp ý kiến của các bạn , để mình có thể hoàn thiện được tool thêm nhiều tính năng hấp dẫn. Mình sẽ lấy giá rất mềm cho các bạn đầu tiên sử dụng, giới hạn đầu tiên sẽ là 100 member nhé.Sau đó sẽ cập nhật lại bảng giá để duy trì và phát triển tool tốt hơn cho các bạn sử dụng</p>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@stop
