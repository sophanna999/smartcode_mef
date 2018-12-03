<style>
    .contain-color {
        background-color: #f1f1f1;
        padding: 2.01em 16px;
        margin: 20px 0;
        box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;
    }

</style>
<div class="contain-color">
    <p style="font-family: 'khmer mef1';font-size: 14px;color: green;font-weight: bold;">គោរពជូន <span style="font-family: 'khmer mef2'; font-size: 16px">{{$data->FULL_NAME_KH}} </span></p><br>
    <p style="font-family: 'khmer mef1';font-size: 14px;color: green;font-weight: bold;">តើលោកអ្នកបានស្នើរផ្លាស់ប្តូរពាក្យសម្ងាត់ដែរឫទេ?</p>
    <p style="font-family: 'khmer mef1';font-size: 14px;color: green;font-weight: bold;">
        ប្រសិនបើបានស្នើរសូមចុចតំណខាងក្រោមដើម្បីធ្វើការផ្លាស់ប្តូរពាក្យសម្ងាត់ថ្មី៖
    </p>
    <p style="padding:10px 20px;background:#002060;width:200px;text-align: center;">
        <a class="btn btn-primary" href="{{asset('register/reset-password-action?hashkey='.$data->HASHKEY)}}" style="font-family: 'khmer mef1';color: white;text-decoration: none;font-size: 24px;">ភ្លេចពាក្យសម្ងាត់</a>
    </p>
</div>