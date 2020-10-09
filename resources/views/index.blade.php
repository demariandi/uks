@component('template-header')UKS @endcomponent
@extends('template-sidebar')
	@section('postItem','active')
	@section('topbar','Sistem UKS')
	@section('content')
		 <!-- Notif Sukses Add Post -->
		 @if(session()->get('notif'))
		 <div class="alert alert-success">
         {{ session()->get('notif') }}
		 </div>
		  @endif

          <!-- DataTables -->
          <div class="card shadow mb-4">
            <div class="card-header">
				<div class="d-flex">
					<h6 class="mr-auto my-auto font-weight-bold text-primary">Daftar Siswa</h6>
					@if(Session::get('usertype') == 0)
					<a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahData"><i class="fas fa-plus"></i> Tambah Data</a>
					@endif
				</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Waktu</th>
							<th>NISN</th>
							<th>Nama</th>
							<th>Keterangan</th>
							@if(Session::get('usertype') == 1)
							<th>Cetak</th>
							@endif
							@if(Session::get('usertype') == 0)
							<th>Aksi</th>
							@endif
						</tr>
					</thead>
					<tbody>
					   @foreach ($riwayat as $r)
						<tr>
							<td data-sort="{{$r->waktu}}">{{strftime( "%d %b %Y - %H:%M", strtotime($r->waktu))}}</td>
							<td>{{$r->nisn}}</td>
							<td>{{$r->nama}}</td>
							<td>{{$r->keterangan}}</td>
							
							@if(Session::get('usertype') == 1)
							<td>
							<!-- <a href="javascript:window.print()">cetak</a> -->
							
							<!-- mengurangi margin header dan footer -->
							<style type="text/css" media="print">
								@page 
								{
									size: auto;   /* auto is the initial value */
									margin: 0mm;  /* this affects the margin in the printer settings */
								}
							</style>
							
							<a href="javascript:window.print()" class="btn btn-sm btn-success mb-3" ><i class="fas fa-download"></i> cetak</a>
							
							@endif

							@if(Session::get('usertype') == 0)
							
							<td style='white-space: nowrap'>
							<div class="pull-left">
								
							<a href="javascript:window.print()" class="btn btn-sm btn-primary mb-3" ><i class="fas fa-download"></i> Cetak  </a>
								<form action=""> 
									
								</form>
							<a href="" class="btn btn-sm btn-success mb-2" data-toggle="modal" data-target="#edit-{{$r->id}}" ><i class="fas fa-edit"></i> Edit </a>
								<form method="post" action="/hapus">
							<!-- </td>
							<td>	 -->
							@csrf
									<input type="text" name="id" class="form-control" value="{{$r->id}}" hidden>
										<button type="submit" class="btn btn-sm btn-danger mb-2"><i class="fas fa-trash"></i> Hapus</button>
								</form>
								
							</td>
							</div>
							@endif
							<!-- Edit Modal -->
							<div class="modal fade" id="edit-{{$r->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="tambahModalLabel">Edit Data</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body">
									<form method="post" action="/edit">
											<div class="form-row">
											<div class="form-group col-md-8">
												<label><b>Waktu</b></label>
												@csrf
												<input type="text" name="waktu" class="form-control" value="{{strftime( "%d %b %Y - %H:%M", strtotime($r->waktu))}}" readonly>
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-8">
												<label><b>Nama</b></label>
												@csrf
												<input type="text" name="nama" class="form-control" value="{{$r->nama}}" readonly>
												<input type="text" name="id" class="form-control" value="{{$r->id}}" hidden>
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-8">
												@csrf
												<label><b>Keterangan</b></label>
												<input type="text" name="keterangan" class="form-control" value="{{$r->keterangan}}">
											</div>
										</div>
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
									<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
									</form>		
								  </div>
								</div>
							  </div>
							</div>
						</tr>
						@endforeach
					</tbody>
				</table>
				
							<!-- Tambah Modal -->
							<div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="tambahModalLabel">Tambah Data</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body">
									<form method="post" action="/tambah">
										<div class="form-row">
											<div class="form-group col-md-8">
												<label><b>Siswa</b></label>
												@csrf
												<select class="custom-select" name="nisn">
												@foreach ($siswa as $s)
												  <option value="{{$s->noinduk}}">{{$s->nama}} | {{$s->noinduk}}</option>
												@endforeach
												</select>
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-8">
												@csrf
												<label><b>Keterangan</b></label>
												<input type="text" name="keterangan" class="form-control">
											</div>
										</div>
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
									<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
									</form>		
								  </div>
								</div>
							  </div>
							</div>
              </div>
            </div>
          </div>
	      @include('template-footer')
	@endsection