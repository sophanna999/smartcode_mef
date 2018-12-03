<?php
$jqxPrefix = '_organization_chat';
$listUrl = asset($constant['secretRoute'].'/organization-chat/index');
?>
@extends('layout.back-end')
@section('content')
    <div id="content-container" class="content-container">
        <div class="panel">
            <div class="row panel-heading custome-panel-headering">
                <div class="form-group title-header-panel">
                    <div class="pull-left">
                        <div class="col-lg-12 col-xs-12">ធនធានមនុស្ស &raquo; រចនាសម្ព័ន្ធគ្រប់គ្រង</div>
                    </div>
                    <div class="pull-right warp-btn-top">
						{{--<button id="btn-detail"><i class="glyphicon glyphicon-print"></i> {{trans('officer.print_officer_card')}}</button>--}}
						
                    </div>
                </div>
                <div id="jqx-grid<?php echo $jqxPrefix;?>"></div>
            </div>
        </div>
    </div>
<style>
	.warp-btn-top > button { margin-right: 15px; }
	.warp-btn-top > form { display : inline-block; margin-right: 15px; }
</style>
<div class="row">
    <div class="col-md-12 col-xs-12 col-lg-12">
        <div id="chart-container"></div>
        <script type="text/javascript" src="{{ asset('orgchat/js/jquery.min.js') }}"></script>
        <script type="text/javascript" src=" {{ asset('orgchat/js/jquery.orgchart.js') }}"></script>
        <script type="text/javascript">
            $(function() {
                var datascource = {
                    'id': '1',
                    'name': 'រដ្ឋមន្ត្រី',
                    'title': 'Minister',
                    'children': [
                        { 'id': '2', 'name': 'រដ្ឋលេខាធិការ', 'title': 'department manager', 'className': 'middle-level'
                        },
                        { 'id': '3','name': 'អនុរដ្ឋលេខាធិការ', 'title': 'department manager', 'className': 'middle-level'
                        },
                        { 'id': '4','name': 'ខុទ្ទកាល័យ', 'title': 'department manager', 'className': 'middle-level'
                        },
                        { 'id': '5','name': 'ទីប្រឹក្សា', 'title': 'department manager', 'className': 'middle-level'
                        },
                        { 'id': '6','name': 'អគ្គលេខាធិការដ្ឋាន', 'title': 'department manager', 'className': 'middle-level',
                            'children':[
                                { 'id': '9','name': 'ន.រដ្ឋបាលនិងហិរញ្ញវត្ថុ', 'title': 'senior engineer', 'className': 'rd-dept' },
                                {'id': '10', 'name': 'ន.បុគ្គលិក', 'title': 'senior engineer', 'className': 'rd-dept'},
                                {'id': '11', 'name': 'ន.នីតិកម្ម', 'title': 'senior engineer', 'className': 'rd-dept'},
                                {'id': '11', 'name': 'ន.បច្ចេកវិទ្យាព័ត៌មាន', 'title': 'senior engineer', 'className': 'rd-dept',
                                    'children' :[
                                        {'id': '9','name': 'ការិយាល័យទី១', 'title': 'senior engineer', 'className': 'rd-dept' },
                                        {'id': '10', 'name': 'ការិយាល័យទី២', 'title': 'senior engineer', 'className': 'rd-dept'},
                                        {'id': '11', 'name': 'ការិយាល័យទី៣', 'title': 'senior engineer', 'className': 'rd-dept'},
                                        {'id': '9','name': 'ការិយាល័យទី៤', 'title': 'senior engineer', 'className': 'rd-dept' },
                                        {'id': '10', 'name': 'ការិយាល័យទី៥', 'title': 'senior engineer', 'className': 'rd-dept'},
                                        {'id': '11', 'name': 'ការិយាល័យទី៦', 'title': 'senior engineer', 'className': 'rd-dept'},

                                    ]
                                },
                                {'id': '11', 'name': 'មន្ទីសេដ្ឋកិច្ចនិងហិរញ្ញវត្ថុរាជធានី', 'title': 'senior engineer', 'className': 'rd-dept'},
                            ]
                        },
                        { 'id': '7','name': 'អគ្គនាយកដ្ឋាន គោលនយោបាយសេដ្ឋកិច្ច និងហិរញញវត្ថុ', 'title': 'department manager', 'className': 'middle-level',
                            'children' :[
                                { 'id': '1','name': 'ន.គោលនយោបាយម៉ាក្រូសេដ្ឋកិច្ចនិងសារពើពន្ធ', 'title': 'senior engineer', 'className': 'rd-dept' },
                                {'id': '2', 'name': 'ន.សវនកម្មផ្ទៃក្នុង ថ្នាក់មូលដ្ឋាន', 'title': 'senior engineer', 'className': 'rd-dept'},
                                {'id': '3', 'name': 'ន.សវនកម្ម បច្ចេកវិទ្យាព័ត៌មាន', 'title': 'senior engineer', 'className': 'rd-dept'},
                            ]
                        },
                        { 'id': '8','name': 'អគ្គនាយកដ្ឋាន សវនកម្មផ្ទៃក្នុង', 'title': 'department manager', 'className': 'middle-level',
                            'children': [
                                { 'id': '9','name': 'ន.សវនកម្មផ្ទៃក្នុង ថ្នាក់កណ្តាល', 'title': 'senior engineer', 'className': 'rd-dept' },
                                {'id': '10', 'name': 'ន.សវនកម្មផ្ទៃក្នុង ថ្នាក់មូលដ្ឋាន', 'title': 'senior engineer', 'className': 'rd-dept'},
                                {'id': '11', 'name': 'ន.សវនកម្ម បច្ចេកវិទ្យាព័ត៌មាន', 'title': 'senior engineer', 'className': 'rd-dept'},


                            ]
                        },
                    ]
                };
                $('#chart-container').orgchart({
                    'data' : datascource,
                    'nodeID': 'id',
                    'nodeContent': 'title',
                    'zoom': true,
                    'pan': true,
                    'createNode': function($node, data) {
                        var secondMenuIcon = $('<i>', {
                            'class': 'fa fa-file-image-o second-menu-icon',
                            click: function() {
                                $(this).siblings('.second-menu').toggle();
                            }
                        });
                        // console.log(data);
                        var avatar = data.id + '.jpg';
                        var img = '{{asset('orgchat/avatar')}}/' + avatar;
                        var secondMenu = '<div class="second-menu"><img class="avatar" src="' + img + '">' +
                            '</div>';
                        $node.append(secondMenuIcon).append(secondMenu);
                    }
                });
            });
        </script>
    </div>
</div>

@endsection