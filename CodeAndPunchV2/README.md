## Code and punch event - EHC Ethical Hacker Club

Viết 1 trang web quản lý lớp học, gồm 2 role chính: giáo viên, sinh viên.

-   Thông tin của mỗi role gồm các trường cơ bản: tên đăng nhập, mật khẩu, họ tên, email, số điện thoại.

\* Quản lý thông tin:

-   Giáo viên có thể thêm, sửa, xoá các thông tin của các sinh viên và của chính mình.
-   Sinh viên có thể thêm, sửa, thông tin của chính mình trừ tên đăng nhập và họ tên.
-   1 người dùng bất kỳ được phép xem danh sách các người dùng trên website và xem thông tin chi tiết của 1 người khác.

\*Chức năng giao bài, trả bài:

-   Giáo viên có thể upload file bài tập lên. Các sinh viên có thể xem danh sách bài tập và tải file bài tập về.
-   Sinh viên có thể upload bài làm tương ứng với bài tập được giao. Chỉ giáo viên mới có thể nhìn thấy danh sách bài làm này.

\* Chức năng cho phép giáo viên tổ chức 1 trò chơi giải đố:

-   Giáo viên tạo challenge, trong đó cần thực hiện: upload lên 1 file txt có nội dung là 1 bài thơ, văn,... tên file được viết dưới định dạng không dấu và các từ các nhau bởi 1 khoảng trắng.
    Sau đó nhập gợi ý về quyển sách và submit. (đáp án chính là tên file mà giáo viên upload lên. Yêu cầu: không lưu đáp án ra file, Database,... ).
-   Sinh viên xem gợi ý và nhập lại đáp án. Khi sinh viên nhập đúng thì trả về nội dung bài thơ, văn,... trong file đáp án

## Last features :

-   [x] Signin
-   [x] Lignup
-   [x] Session
-   [x] List user, all users can see each other's profiles
-   [x] Add user, new user required student role
-   [ ] Edit user, user can edit their profile, or if user is a teacher then can edit student user, admin can edit all users
-   [x] Delete user, user can delete their profile, or if user is a teacher then can delete student user, admin can delete all users
-   [x] View profile
-   [ ] Upload homework
-   [ ] Download homework
-   [ ] Submit student homework answers
-   [ ] View student homework answers
-   [ ] Create challenge
-   [ ] Submit student challenge answers

## Setup

```
    # This code is used to run web on local
    # Start Apache and MySQL on XAMPP
    # Start terminal in CodeAndPunchV2 directory

    # Prepare database by using migrate
    php artisan migrate

    # Start server
    php artisan serve

    # Website can be access at: http://localhost:8000/
```

## Resources

-   [Google](https://www.google.com/)
-   [PHP 8.0.28](https://www.php.net/downloads.php#:~:text=Old%20Stable%20PHP%208.0.28)
-   [Laravel 9.52.7](https://laravel.com/docs/10.x)
-   [ChatGPT](https://openai.com/product/chatgpt)

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
