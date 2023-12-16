@extends('layouts.app')
@section('title','Participants')
@section('content')

    <!-- /.content-header -->
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Registered participants</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Registered participants</li>
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
                                <th>Name</th>
                                {{-- <th>DOB</th> --}}
                                <th>Quiz</th>
                                <th>Result</th>
                                <th>status</th>
                                <th>Actions</th>
                            </tr>
                        <tbody>
                          @foreach ($students as $key=>$std)
                              <tr>
                                  <td>{{ $key+1}}</td>
                                  <td>{{ $std['name']}}</td>
                                  {{-- <td>{{ $std['dob']}}</td> --}}
                                  <td>{{ $std['ex_name']}}</td>
                                  <td>
                                    <?php 
                                    if($std['exam_joined']==1){
                                    ?>
                                          <a href="{{url('admin/admin_view_result/'.$std['id'])}}" class="btn btn-info btn-sm">View result</a>
                                    <?php    
                                    }
                                    ?>


                                  </td>
                                  <td><input type="checkbox" class="student_status" data-id="{{ $std['id']}}" <?php if($std['std_status']==1){ echo "checked";} ?> name="status"></td>
                                  <td>
                                      <a href="{{url('admin/edit_participants/'.$std['user_id'])}}" class="btn btn-primary btn-sm">Edit</a>
                                      <a href="{{url('admin/delete_students/'.$std['id'])}}" class="btn btn-danger btn-sm" onclick="return confirm('¿Are you sure?')">Delete</a>
                                  </td>
                              </tr>
                          @endforeach
                        </tbody>
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
          <h4 class="modal-title">Add new Student</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form action="{{ url('admin/add_new_students')}}" class="database_operation">  
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Enter Name</label>
                            {{ csrf_field()}}
                            <input type="text" required="required" name="name" placeholder="Enter name" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Enter E-mail</label>
                            {{ csrf_field()}}
                            <input type="text" required="required" name="email" placeholder="Enter name" class="form-control">
                        </div>
                    </div>

                    {{-- <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Select DOB</label>
                            <input type="date" required="required" name="dob"  class="form-control">
                        </div>
                    </div> --}}
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Select quiz</label>
                            <select class="form-control" required="required" name="exam">
                                <option value="">Select</option>
                                @foreach ($exams as $exam)
                                    <option value="{{ $exam['id']}}">{{ $exam['title']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" required="required" name="password" placeholder="Enter password" class="form-control">
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
