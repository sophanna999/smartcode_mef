<div style="margin:0px; background: #f8f8f8; ">
        <div width="100%" style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
          <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px">
            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">
              <tbody>
                <tr>
                <td style="vertical-align: top;font-size:24px;" align="center"><h2>ការិយាល័យវៃឆ្លាត</h2></td>
                </tr>
                <tr>
                  <td><h4 style="text-align:center;">ការចាត់តាំងចូលរួមវគ្គបណ្តុះបណ្ដាល</h4></td>
                </tr>
              </tbody>
            </table>
            <div style="padding: 40px; background: #fff;">
              <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                <tbody>
                  <tr>
                  <td style="border-bottom:1px solid #f6f6f6;"><h1 style="font-size:14px; font-family:arial; margin:0px; font-weight:bold;">សួស្ដី {{ $member->full_name }},</h1>
                    @if($state == 'attached')
                      <p style="margin-top:0px; color:#a0a0a0;">អ្នកត្រូវបានចាត់អោយចួលរួមក្នុងវគ្គបណ្ដុះបណ្តាលខាងក្រោម​៖</p>
                    @endif
                    @if($state == 'detached')
                      <p style="margin-top:0px; color:#ff4e4e;">អ្នកត្រូវបានលុបចេញពីវគ្គបណ្ដុះបណ្តាលខាងក្រោម​៖</p>
                    @endif
                      <table class="table table-bordered">
                        <tbody>
                          <tr>
                            <td>កម្មវិធីសិក្សា<span style="float:right;">៖</span> </td>
                            <td>{{$training->course->title}}</td>
                          </tr>
                          <tr>
                            <td>កាលបរិច្ឆេទ<span style="float:right;">៖</span>​ </td>
                            <td>{{ showDate($training->start_date) }} ដល់​ {{ showDate($training->end_date) }}</td>
                          </tr>
                          <tr>
                            <td>ទីតាំង<span style="float:right;">៖</span> </td>
                            <td>{{ $training->location->name }}</td>
                        ​​​  </tr>
                          @if($state == 'attached')
                            <tr>
                              <td>ប្រភេទអ្នកចួលរួម<span style="float:right;">៖</span> </td>
                              <td>{{ trans('training.'.$member->training()->whereTrainingId($training->id)->first()->pivot->type) }}</td>
                            </tr>
                          @endif
                        </tbody>
                      </table>
                      <br>
                      @if($state == 'attached')
                        <p style="margin-top:0px; color:#a0a0a0;">សូមចុចលើតំណខាងក្រោម​ទៅកាន់ប្រព័ន្ធ ការិយាល័យវៃឆ្លាត ​ដើម្បីមើលព័ត៌មានបន្ថែមនិងទាញយកកាលវិភាគ</p>
                        <a href="{{ url('/') }}">ដំណើរការ</a>
                      @endif
                      <p style="margin-top:0px; color:#a0a0a0;"><br></p></td>
                  </tr>
                  <tr>
                    <td style="padding:10px 0 30px 0;">
                        <b>- អគុណ</b> </td>
                    </tr>
                </tbody>
              </table>
            </div>
            <div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px">
              <p> នាយកដ្ឋានបច្ចេកវិទ្យាព័ត៌មាន នៃអគ្គលេខាធិការដ្ឋាន <br>
                admin@mef.gov.kh | +855-23-724 664 | www.mef.gov.kh</p>
            </div>
          </div>
        </div>
      </div>
      