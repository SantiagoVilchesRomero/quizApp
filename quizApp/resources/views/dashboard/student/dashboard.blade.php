@extends('layouts.student')
@section('title','Dashboard')
@section('content')

     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">All quizs</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->

        <div class="row">
          @foreach ($portal_exams as $key=>$exam)
          <?php 
               $cls="bg-info";
          ?>
          <div class="col-lg-6 col-6">
              <div class="small-box <?php echo $cls; ?>">
                  <div class="inner">
                  <h3>{{ $exam['title']}}</h3>
                  </div>
                  <div class="icon">
                  <i class="ion ion-bag"></i>
                  </div>
                      <a data-id="{{ $exam['id']}}"  class="apply_exam small-box-footer">Apply<i class="fas fa-arrow-circle-right"></i></a>
              </div>
          </div>
      @endforeach

        </div>
        <!-- /.row -->
        <!-- Main row -->
        
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  
@endsection
