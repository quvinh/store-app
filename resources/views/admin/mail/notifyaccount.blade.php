<style>
    .btn {
        background-color: #4CAF50;
        /* Green */
        border: none;
        color: white;
        padding: 16px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        transition-duration: 0.4s;
        cursor: pointer;
    }

    .btn-primary {
        background-color: white;
        color: black;
        border: 2px solid #008CBA;
        border-radius: 5px;
    }

    .btn-primary:hover {
        background-color: #008CBA;
        color: white;
    }
</style>
<div style="background-color:#e0e5ff; width: 100%; padding: 20px;">
    <table style="display:table; margin: 0 auto;">
        <tbody>
            <tr>
                <td style="background-color:aliceblue;padding: 20px;">
                    <table>
                        <tbody>
                            <tr>
                                <td style="text-align: center;">
                                    <img src="{{ asset('images/img/logo.png') }}" alt="LOGO" width="128">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p>{{ $data['content'] }}</p>
                                                    <ul>
                                                        <li>Tên đăng nhập: <b>{{ $data['username'] }}</b></li>
                                                        <li>Mật khẩu: <b>{{ $data['password'] }}</b></li>
                                                    </ul>
                                                    <p style="text-align: center;"><a href="#" target="_blank" rel="" class="btn btn-primary">Tới trang quản trị quản lý xét nghiệm</a></p>
                                                    <p>Thân ái, <br>Dailythue</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td><small>© Dailythue - thuemienbac.vn</small></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</div>
