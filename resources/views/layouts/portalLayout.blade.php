<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="SHORTCUT ICON" href="{{ asset('images/favico.png') }}"/>
    <!-- CSRF Token -->
    <meta name="_token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Quest | Webportal') }}</title>

    <!-- Styles -->
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js" type="text/javascript"></script>
    <![endif]-->

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('css/bootstrap-datepicker.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.5/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.5/css/skins/_all-skins.min.css">

    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('css/select2.css') }}">

    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('css/style.css') }}">


    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>

<header>
    <nav class="navbar navbar-default navbar-custom">
        <div class="container">
            <div class="row">
                <div class="navbar-header col-xs-12 col-sm-4 col-md-3 col-pad-0">
                    <a class="navbar-brand" href="{{url('/secure/dashboard')}}">
                        <img src="{{ asset('images/logo.png') }}" alt="Quest" title="Quest" class="img-responsive"/>
                    </a>
                    <div class="nav navbar-left visible-xs">
                        <button type="button" class="navbar-toggle menu-toggle collapsed">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-8 col-md-9 col-pad-0">
                    <div class="nav navbar-left hidden-xs">
                        <button type="button" class="navbar-toggle menu-toggle collapsed">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    @if ((session()->has('user_id'))  )
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="#">Welcome {{ucfirst(Session::get('user_name'))}}</a>
                            </li>
                            <li class="logout">
                                <a href="{{ url('/secure/logout') }}" title="Logout">Logout</a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</header>
<div class="container">
    <div class="row equal-heights-container">
        <aside class="navigation col-xs-12 col-sm-4 col-md-3 col-pad-0 equal-heights" id="primary-nav">
            <div class="visible-xs nav-close clearfix">
                <div> Navigation</div>
                <button type="button" class="btn-orange nb-icon-cross menu-close">Close</button>
            </div>
            <nav>
                <ul>
                    <?php if((Session::get('role_name') == "superAdmin")){ ?>
                    <li><a href="{{URL::to('/portal/branch') }}" class="nb-icon-branch {{ Session::get("menuindex")==2 ? ' active' : '' }}">Branches</a></li>
                    <?php } ?>

                    <li><a href="{{URL::to('/portal/class') }}" class="nb-icon-list {{ Session::get("menuindex")==2 ? ' active' : '' }}">Classes</a></li>
                    <li><a href="{{URL::to('/portal/section') }}" class="nb-icon-section {{ Session::get("menuindex")==5 ? ' active' : '' }}">Sections</a></li>
                    <li><a href="{{URL::to('/portal/subject') }}" class="nb-icon-subject {{ Session::get("menuindex")==3 ? ' active' : '' }}">Subjects</a></li>
                    <li><a href="{{URL::to('/portal/chapter') }}" class="nb-icon-chapter {{ Session::get("menuindex")==4 ? ' active' : '' }}">Chapters</a></li>
                    <li><a href="{{URL::to('/portal/question') }}" class="nb-icon-question {{ Session::get("menuindex")==1 ? ' active' : '' }}">Questions</a></li>
                    <li><a href="{{URL::to('/portal/exam-list') }}" class=" nb-icon-exam {{ Session::get("menuindex")==6 ? ' active' : '' }}">Exams</a></li>
                    <li><a href="{{URL::to('/portal/user') }}" class="nb-icon-users {{ Session::get("menuindex")==6 ? ' active' : '' }}">Students</a></li>
                    <li><a href="{{URL::to('/portal/teacher') }}" class="nb-icon-teacher {{ Session::get("menuindex")==6 ? ' active' : '' }}">Teachers</a></li>

                </ul>
            </nav>
        </aside>
        <section class="col-xs-12 col-sm-8 col-md-9 col-pad-0 equal-heights">
            @yield('content')
        </section>
    </div>
</div>
<br>
<footer>
    <div class="container">
        <div class="col-xs-12 col-sm-6">
            <ul class="social-icons">
                <li><a href="#" class="nb-icon-facebook">Facebook</a></li>
                <li><a href="#" class="nb-icon-linkedin">Linkedin</a></li>
                <li><a href="#" class="nb-icon-googleplus">Google Plus</a></li>
                <li><a href="#" class="nb-icon-twitter">Twitter</a></li>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="pull-right copyrights">
                Copyright <a href="#">Quest</a> &copy; <?php echo date('Y');?>
            </div>
        </div>
    </div>
</footer>

<div class="device-xs visible-xs"></div>
<script>

    var base_URL = "{{URL::to('/')}}";
    var baseURL = "{{URL::to('/')}}";
</script>
<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/select2.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.equalheights.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class='AjaxisModal'>
    </div>
</div>
<!-- Compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.5/js/app.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.5/js/demo.js"></script>
<script src="{{URL::asset('js/AjaxisBootstrap.js') }}"></script>
<script src="{{URL::asset('js/scaffold-interface-js/customA.js') }}"></script>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.jqueryui.min.js"></script>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="all" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap4.min.css">

<script>
    $(document).ready(function () {
        $('#data_table').DataTable({
            "paging": true,
            "ordering": true,
            "info": false,
            "pagingType": "full_numbers"
        });

    });
</script>


<script>
    $(function () {
        var old_branch = $("#old_branch").val();
        if (old_branch) {
            if ($("#branches_branchID").length) {
                $('#branches_branchID').trigger('change');
                $("#branches_branchID").trigger("chosen:updated");
            } else {
                update_class_dropdown(old_branch);
            }
        }


    });


    $("#subject_name").on("change", function () {


        var class_id = $('#class_name').val();
        var branch_id = $("#old_branch").val() != '' ? $("#old_branch").val() : $("#branches_branchID").val();
        if ($(this).data("domulti") && $(this).data("domulti") == 'yes') {
            $('#chapter_name').empty();
            var subject_id = '';
            $('#subject_name :selected').each(function (i, selected) {
                subject_id += $(selected).val() + ",";
            });
            subject_id = subject_id.replace(/,\s*$/, '');
            update_chapter_dropdown(branch_id, class_id, subject_id, "multiple");
        } else {
            $('#chapter_name').empty().append('<option selected="selected" value="">Select A Chapter</option>');
            var subject_id = $(this).val();
            if (class_id && branch_id && subject_id) {
                update_chapter_dropdown(branch_id, class_id, subject_id, "single");
            }
        }
    })


    $("#class_name").on("change", function () {
        var class_id = $(this).val();
        $("#chapter_name").empty();
        var branch_id = $("#old_branch").val() != '' ? $("#old_branch").val() : $("#branches_branchID").val();


        if ($("#subject_name").length) {
            if ($("#subject_name").data("domulti") && $("#subject_name").data("domulti") == 'yes') {
                $('#subject_name').empty();
                $("#chapter_name").empty();
            } else {
                $('#subject_name').empty().append('<option selected="selected" value="">Select A Subject</option>');
            }

            if (class_id && branch_id) {
                update_subject_dropdown(branch_id, class_id);
            }
        }

        if ($("#sectionID").length) {
            $("#sectionID").empty();
            $("#chapter_name").empty();
            $('#sectionID').empty().append('<option selected="selected" value="">Select A Section</option>');
            if (class_id && branch_id) {

                update_section_dropdown(branch_id, class_id);
            }
        }
    })


    $("#branches_branchID").on("change", function () {
        $('#chapter_name').empty();
        $('#subject_name').empty();
        $('#class_name').empty().append('<option selected="selected" value="">Select A Class</option>');
        var branch_id = $(this).val();
        update_class_dropdown(branch_id);
    })


    function update_chapter_dropdown(branch_id, class_id, subject_id, flag) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: base_URL + "/secure/get_avil_chapters",
            data: {_token: $("#_token").val(), class_id: class_id, branch_id: branch_id, subject_id: subject_id, flag: flag},
            dataType: "json"
        })
                .done(function (resultData) {

                    $.each(resultData, function (i, item) {
                        $('#chapter_name').append($('<option>', {
                            value: item.chapterID,
                            text: item.chapter
                        }));
                    });
                })
                .fail(function (error) {
                    console.error(error);
                })
                .always(function () {

                    if ($("#old_chapter").val() != '' && $("#old_chapter").val() != null) {

                        if ($("#chapter_name").data("domulti") && $("#chapter_name").data("domulti") == 'yes' && $("#old_chapter").val() != 'null') {

                            var valArr = JSON.parse($("#old_subject").val());
                            var i = 0, size = valArr.length,
                                    $options = $('#chapter_name option');
                            for (i; i < size; i++) {
                                $options.filter('[value="' + valArr[i] + '"]').prop('selected', true);
                            }
                            $('#old_chapter').change();

                        } else {
                            $('#chapter_name').val($("#old_chapter").val()).change();
                        }

                        //$("#subject").trigger("chosen:updated");
                    }
                });
    }

    function update_subject_dropdown(branch_id, class_id) {
        if (branch_id && class_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: base_URL + "/secure/get_avil_subjects",
                data: {_token: $("#_token").val(), class_id: class_id, branch_id: branch_id},
                dataType: "json"
            })
                    .done(function (resultData) {

                        $.each(resultData, function (i, item) {
                            $('#subject_name').append($('<option>', {
                                value: item.subjectID,
                                text: item.subject
                            }));
                        });
                    })
                    .fail(function (error) {
                        console.error(error);
                    })
                    .always(function () {

                        if ($("#old_subject").val() != '' && $("#old_subject").val() != null) {

                            if ($("#subject_name").data("domulti") && $("#subject_name").data("domulti") == 'yes' && $("#old_subject").val() != 'null') {

                                var valArr = JSON.parse($("#old_subject").val());
                                var i = 0, size = valArr.length,
                                        $options = $('#subject_name option');
                                for (i; i < size; i++) {
                                    $options.filter('[value="' + valArr[i] + '"]').prop('selected', true);
                                }
                                $('#subject_name').change();

                            } else {
                                $('#subject_name').val($("#old_subject").val()).change();
                            }
                            //$("#subject").trigger("chosen:updated");
                        }
                    });
        }
    }


    function update_class_dropdown(branch_id) {
        if (branch_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: base_URL + "/secure/get_avil_classes",
                data: {_token: $("#_token").val(), branch_id: branch_id},
                dataType: "json"
            }).done(function (resultData) {
                $.each(resultData, function (i, item) {
                    $('#class_name').append($('<option>', {
                        value: item.classID,
                        text: item.class_name
                    }));
                });
            })
                    .fail(function (error) {
                        console.error(error);
                    })
                    .always(function () {
                        if ($("#old_branch").val() != '' && $("#old_branch").val() != null) {
                            if ($("#old_branch").val()) {
                                $('#class_name').val($("#old_class").val());
                                $("#class_name").trigger("chosen:updated");


                                /** For subject dropdown **/
                                if ($("#class_name").length) {
                                    var old_class = $("#old_class").val();
                                    if (old_class) {
                                        $('#class_name').trigger('change');
                                        $("#class_name").trigger("chosen:updated");
                                    }
                                }
                            }
                        }
                    });
        }
    }


    function update_section_dropdown(branch_id, class_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: base_URL + "/secure/get_avil_sections",
            data: {_token: $("#_token").val(), class_id: class_id, branch_id: branch_id},
            dataType: "json"
        })
                .done(function (resultData) {

                    $.each(resultData, function (i, item) {
                        $('#sectionID').append($('<option>', {
                            value: item.sectionID,
                            text: item.section_name
                        }));
                    });
                })
                .fail(function (error) {
                    console.error(error);
                })
                .always(function () {

                    if ($("#old_section").val() != '' && $("#old_section").val() != null) {
                        $('#sectionID').val($("#old_section").val());

                        //$("#subject").trigger("chosen:updated");
                    }
                });
    }


    if ($(".status_message").length) {
        setTimeout(function () {
            $(".status_message").hide();
        }, 1000);
    }
</script>
@yield('page_scripts')
</body>
</html>