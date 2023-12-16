@extends('layouts.app')
@section('title','Quiz')
@section('content')

    <!-- /.content-header -->
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Manage Quiz</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Quiz</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <!-- Default box -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Title</h3>
  
                  <div class="card-tools">
                        <a class="btn btn-info btn-sm" href="javascript:;" data-toggle="modal" data-target="#myModal">Add new</a>
                  </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered table-hover datatable">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        <tbody>
                           @foreach ($exams as $key=>$exam)
                               <tr>
                                   <td>{{ $key+1}}</td>
                                   <td>{{ $exam['title']}}</td>
                                   <td><input type="checkbox" class="exam_status" data-id="{{ $exam['id']}}" <?php if($exam['status']==1){ echo "checked";} ?> name="status"></td>
                                   <td>
                                       <a href="{{ url('admin/edit_quiz/'.$exam['id'])}}" class="btn btn-info">Edit</a>
                                       <a href="{{ url('admin/delete_exam/'.$exam['id'])}}" class="btn btn-danger hrefDelete" 
                                          onclick="return confirm('¿Are you sure?')">Delete</a>
                                       <a href="{{ url('admin/add_questions/'.$exam['id'])}}" class="btn btn-primary">Questions</a>
                                   </td>
                               </tr>
                           @endforeach
                        </tbody>
                        <tfoot>
                            
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
      </section>
    </div>
    <!-- /.content-header -->
    <!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add new Exam</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form action="{{ url('/admin/add_new_exam')}}" class="database_operation">  
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Enter title</label>
                            {{ csrf_field()}}
                            <input type="text" required="required" name="title" placeholder="Enter title" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <button class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </div>
            </form>
      </div>
      
    </div>
    </div>	
 
@endsection
