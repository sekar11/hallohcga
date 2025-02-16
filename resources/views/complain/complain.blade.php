@extends('include/mainlayout')
@section('title', 'complain')
@section('content')
    <div class="pagetitle">
      <h1>Digital Complain</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
          <li class="breadcrumb-item active">Digital Complain</li>
        </ol>
      </nav>
    </div>
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><i class="fa-solid fa-square-poll-vertical"></i> Digital Complain</h5>
              <button type="button" class="btn bi bi-plus btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#complainModal"> Add Complain</button>
              <br><br>

              <!-- Modal View -->
                <div class="modal fade modal-view" id="viewComplainModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-6" id="btn-view">View Complain</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="complain-details">
                                    <div class="detail">
                                        <label for="nama_complain">Nama:</label>
                                        <span id="nama_complain"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="divisi_complain">Departemen:</label>
                                        <span id="dept_complain"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="tanggal_complain">Tanggal Complain:</label>
                                        <span id="tanggal_complain"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="jam_kirim">Waktu Pengiriman Complain:</label>
                                        <span id="jam_kirim"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="area">Area:</label>
                                        <span id="area_complain"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="gedung_complain">Gedung:</label>
                                        <span id="gedung_complain"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="lokasi_complain">Lokasi:</label>
                                       <span id="lokasi_complain" class="info-text"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="permasalahan_complain">Permasalahan:</label>
                                       <span id="permasalahan_complain"></span>
                                    </div>

                                    <div class="detail">
                                        <label id="label_foto_deviasi" for="fotodeviasi_complain">Foto Deviasi:</label>
                                        <div id="fotodeviasi_complain" class="foto-container">

                                        </div>
                                    </div>
                                    <div class="detail">
                                        <label for="pending">Keterangan Pending :</label>
                                        <span id="pending"> </span>
                                    </div>
                                    <div class="detail">
                                        <label for="kategori">Kategori :</label>
                                        <span id="kategori_complain"> </span>
                                    </div>
                                    <div class="detail">
                                        <label for="skala">Skala :</label>
                                        <span id="skala_complain"> </span>
                                    </div>
                                    <div class="detail">
                                        <label for="duedate">Due Date :</label>
                                        <span id="duedate_complain"> </span>
                                    </div>
                                    <div class="detail">
                                        <label for="aprroval">Crew PIC :</label>
                                        <span id="crew_pic"> </span>
                                    </div>
                                    <div class="detail">
                                        <label for="identification">Identifikasi Permasalahan:</label>
                                       <span id="identification_complain"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="correctiveaction">Tindakan Perbaikan :</label>
                                       <span id="correctiveaction_complain"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="validasi_crew_on">Tanggal Perbaikan :</label>
                                       <span id="validasi_crew_on"></span>
                                    </div>

                                    <div class="detail">
                                        <label id="label_foto_perbaikan" for="fotoperbaikan_complain">Foto Perbaikan:</label>
                                        <div id="fotoperbaikan_complain" class="foto-container"> </div>
                                    </div>
                                     <div class="detail">
                                        <label for="revisi_by">Revisi by GA/GL:</label>
                                        <span id="revisi_by_gagl"> </span>
                                    </div>
                                    <div class="detail">
                                        <label for="revisi_desc">Keterangan Revisi by GA/GL:</label>
                                        <span id="revisi_desc"> </span>
                                    </div>
                                    <div class="detail">
                                        <label for="reject_by">Reject by GA/GL:</label>
                                        <span id="reject_by"> </span>
                                    </div>
                                    <div class="detail">
                                        <label for="reject_desc">Keterangan Reject by GA/GL:</label>
                                        <span id="reject_desc"> </span>
                                    </div>
                                    <div class="detail">
                                        <label for="approval_desc">Keterangan Approval GA/GL:</label>
                                        <span id="approval_desc"> </span>
                                    </div>
                                    <div class="detail">
                                        <label id="label_foto_hasil_perbaikan" for="fotohasilperbaikan_complain">Foto Hasil Perbaikan by GA/GL:</label>
                                        <div id="fotohasilperbaikan_complain" class="foto-container">
                                        </div>
                                    </div>
                                    <div class="detail">
                                        <label for="reject_by_crew">Reject by Crew/Teknisi:</label>
                                        <span id="reject_by_crew"> </span>
                                    </div>
                                    <div class="detail">
                                        <label for="reject_desc_crew">Keterangan Reject by Crew/Teknisi:</label>
                                        <span id="reject_desc_crew"> </span>
                                    </div>
                                    <div class="detail">
                                        <label for="revisi_by_crew">Revisi by GA/GL to Crew:</label>
                                        <span id="revisi_by_crew"> </span>
                                    </div>
                                    <div class="detail">
                                        <label for="revisi_desc_crew">Keterangan Revisi  GA/GL to Crew:</label>
                                        <span id="revisi_desc_crew"> </span>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal View -->

              <!-- Modal Add -->
                <div class="modal fade modal_add" id="complainModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mode="add">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="btn-add">Add Complain</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- <input type="hidden" name="_token" value="{{{ csrf_token() }}}" /> --}}
                        <input type="hidden" name="id" id="id" />
                        <input type="hidden" name="action_flag" id="action_flag" />
                        <input type="hidden" name="tgl_mulai" id="tgl_mulai" />
                        {{-- <input type="hidden" name="last_seq" id="last_seq" value="{{{$last_seq}}}" /> --}}

                        <form class="row g-3 needs-validation" method="POST" enctype="multipart/form-data" accept="image/*" capture="environment">
                        @csrf
                            <div class="col-md-4">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="tanggal_add" name="tanggal_add" placeholder="Tanggal">
                                <label for="message-text">Tanggal </label>
                            </div>
                            </div>
                            <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-control" id="area_add" name="area_add">
                                    <option value="">Pilih Area</option>
                                    <option value="Mess">MESS</option>
                                    <option value="Office">Office</option>
                                    <option value="CSA 1">CSA 1</option>
                                    <option value="CSA 2">CSA 2</option>
                                    <option value="CSA 3">CSA 3</option>
                                    <option value="CSA FUEL">CSA FUEL</option>
                                    <option value="PITSTOP">PITSTOP</option>
                                    <option value="OTHER">Lainnya</option>
                                </select>

                                <label for="area_add">Area</label>
                            </div>
                            </div>
                            <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-control" id="gedung_add" name="gedung_add">
                                    <option value="">Pilih Gedung</option>

                                </select>
                                <label for="gedung_add">Gedung</label>
                            </div>

                            </div>
                            <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="lokasi_add" name="lokasi_add" placeholder="Lokasi">
                                <label for="message-text">Lokasi</label>
                            </div>
                            </div>
                            {{-- //sekar --}}
                            <div class="col-md-8">
                            <div class="form-floating">
                                <input type="file" class="form-control" id="fotodeviasi_add" name="fotodeviasi_add" placeholder="Foto_Deviasi">
                                <label for="message-text">Foto Deviasi</span></label>
                            </div>
                            </div>
                            <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="permasalahan_add" name="permasalahan_add" placeholder="permasalahan_add" style="height: 100px;" required>
                                <label for="permasalahan_add"> Permasalahan <span style="color:red">*</span></label>
                            </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-yes-add">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <div id="loading-spinner" >
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                        </div>
                    </div>
                    </div>
                </div>
                </div>
              {{-- End Modal Add --}}

              <!--begin::Modal Revisi GA GL-->
              <div class="modal fade modal_revisi" id="revisiModalgagl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Revisi Complain</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </button>
                          </div>
                          <div class="modal-body">
                              <form class="kt-form kt-form--label-right form_revisi" action="/complain/revisi"  method="POST" enctype="multipart/form-data" autocomplete="off">
                                  @csrf
                                  <div class="form-group">
                                      <label for="message-text" class="form-control-label">Pesan Revisi complain <span style="color:red">*</span></label>
                                      <textarea class="form-control" id="revisi" name="revisi" rows="8"></textarea>
                                  </div>
                              </form>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary" id="btn-yes-revisi">Kirim</button>
                              <div id="loading-spinner" >
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!--end::Modal Revisi-->

              <!--begin::Modal Reject GA GL-->
              <div class="modal fade modal_reject" id="rejectModalgagl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Reject Complain</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </button>
                          </div>
                          <div class="modal-body">
                              <form class="kt-form kt-form--label-right form_reject" action="/complain/reject"  method="POST" enctype="multipart/form-data" autocomplete="off">
                                  @csrf
                                  <div class="form-group">
                                      <label for="message-text" class="form-control-label">Pesan Reject complain <span style="color:red">*</span></label>
                                      <textarea class="form-control" id="reject" name="reject" rows="8"></textarea>
                                  </div>
                              </form>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary" id="btn-yes-reject">Kirim</button>
                              <div id="loading-spinner" >
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!--end::Modal Revisi-->

              <!--begin::Modal Validasi GA GL-->
              <div class="modal fade modal_validasi" id="validasiModalgagl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Validasi GA/GL</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </button>
                          </div>
                          <div class="modal-body">
                              <form class="kt-form kt-form--label-right form_validasi" action="/complain/validasigagl" method="POST" enctype="multipart/form-data" autocomplete="off">
                                @csrf

                                <!-- Input Kategori -->
                                <div class="form-group">
                                    <label for="kategori" class="form-control-label" style="font-size: smaller;">Kategori <span style="color:red">*</span></label>
                                    <select class="form-control" id="kategori" name="kategori">
                                        <option value="">- Pilih Kategori -</option>
                                        <option value="Dormitory">Dormitory</option>
                                        <option value="Civil">Civil</option>
                                        <option value="MEP">MEP</option>
                                        <option value="Catering">Catering</option>
                                        <option value="Transportasi">Transportasi</option>
                                        <option value="Tiket">Tiket</option>
                                    </select>
                                </div>

                                <!-- Input Skala -->
                                <div class="form-group">
                                    <label for="skala" class="form-control-label" style="font-size: smaller;">Skala <span style="color:red">*</span></label>
                                    <select class="form-control" id="skala" name="skala" onchange="updateDueDate()">
                                        <option value="">- Pilih Skala -</option>
                                        <option value="Prioritas">Prioritas</option>
                                        <option value="Mayor">Mayor</option>
                                        <option value="Minor">Minor</option>
                                    </select>
                                </div>

                                <!-- Input Due Date -->
                                <div class="form-group">
                                    <label for="due_date" class="form-control-label" style="font-size: smaller;">Due Date <span style="color:red">*</span></label>
                                    <input type="date" class="form-control" id="due_date" name="due_date" readonly>
                                </div>

                                <!-- Input Crew PIC -->
                                <div class="form-group">
                                    <label for="crew_pic" class="form-control-label" style="font-size: smaller;">Crew PIC <span style="color:red">*</span></label>
                                    <select class="form-control" id="crew_picadd" name="crew_picadd">
                                        <option value="">- Pilih Crew PIC -</option>
                                    </select>
                                </div>

                            </form>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary" id="btn-yes-validasi">Kirim</button>
                              <div id="loading-spinner" >
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!--end::Modal Revisi-->

              <!--begin::Modal pending GA GL-->
              <div class="modal fade modal_revisi" id="pendingModalgagl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Pending Data</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </button>
                          </div>
                          <div class="modal-body">
                              <form class="kt-form kt-form--label-right form_pendingGagl" action="/complain/revisi"  method="POST" enctype="multipart/form-data" autocomplete="off">
                                  @csrf
                                  <div class="form-group">
                                      <label for="message-text" class="form-control-label">Pesan Pending Data <span style="color:red">*</span></label>
                                      <textarea class="form-control" id="pendingGagl" name="pendingGagl" rows="8"></textarea>
                                  </div>
                              </form>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary" id="btn-yes-pendingGagl">Kirim</button>
                              <div id="loading-spinner" >
                                   <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!--end::Modal Pending GA/GL-->

              <!--begin::Modal Validasi Crew-->
              <div class="modal fade modal_validasi" id="validasiCrewModalgagl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Validasi Crew</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </button>
                          </div>
                          <div class="modal-body">
                              <form class="kt-form kt-form--label-right form_validasi_crew" action="/complain/validasigagl" method="POST" enctype="multipart/form-data" autocomplete="off">
                                @csrf

                                <!-- Input Kategori -->
                                <div class="form-group">
                                    <label for="kategori" class="form-control-label" style="font-size: smaller;">Identifikasi Permasalahan <span style="color:red">*</span></label>
                                    <textarea class="form-control" id="identification" name="identification" rows="3"></textarea>
                                </div>

                                <!-- Input Skala -->
                                <div class="form-group">
                                    <label for="kategori" class="form-control-label" style="font-size: smaller;">Tindakan Perbaikan <span style="color:red">*</span></label>
                                    <textarea class="form-control" id="corrective_action" name="corrective_action" rows="3"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="kategori" class="form-control-label" style="font-size: smaller;">Foto Perbaikan <span style="color:red">*</span></label>
                                    <input type="file" class="form-control" id="foto_perbaikan" name="foto_perbaikan" placeholder="Unggah Foto Perbaikan" />
                                </div>


                            </form>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary" id="btn-yes-validasi_crew">Kirim</button>
                              <div id="loading-spinner-validasi" >
                                   <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!--end::Modal Validasi Crew-->

              <!--begin::Modal Reject crew-->
              <div class="modal fade modal_reject" id="rejectCrewModalgagl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Reject Complain</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </button>
                          </div>
                          <div class="modal-body">
                              <form class="kt-form kt-form--label-right form_reject_crew" action="/complain/rejectcrew"  method="POST" enctype="multipart/form-data" autocomplete="off">
                                  @csrf
                                  <div class="form-group">
                                      <label for="message-text" class="form-control-label">Pesan Reject Complain <span style="color:red">*</span></label>
                                      <textarea class="form-control" id="reject_crew" name="reject_crew" rows="8"></textarea>
                                  </div>
                              </form>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary" id="btn-yes-reject_crew">Kirim</button>
                              <div id="loading-spinner" >
                                   <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!--end::Modal Reject crew-->

              <!--begin::Modal Revisi crew-->
              <div class="modal fade modal_reject" id="revisiCrewModalgagl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Reject Complain</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </button>
                          </div>
                          <div class="modal-body">
                              <form class="kt-form kt-form--label-right form_revisi_crew" action="/complain/revisicrew"  method="POST" enctype="multipart/form-data" autocomplete="off">
                                  @csrf
                                  <div class="form-group">
                                      <label for="message-text" class="form-control-label">Pesan Revisi Complain <span style="color:red">*</span></label>
                                      <textarea class="form-control" id="revisi_crew" name="revisi_crew" rows="8"></textarea>
                                  </div>
                              </form>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary" id="btn-yes-revisi_crew">Kirim</button>
                              <div id="loading-spinner" >
                                   <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!--end::Modal Revisi crew-->

              <!--begin::Modal Done GA/GL-->
              <div class="modal fade modal_validasi" id="approvalModalgagl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Approval</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </button>
                          </div>
                          <div class="modal-body">
                              <form class="kt-form kt-form--label-right form_approval" action="/complain/validasigagl" method="POST" enctype="multipart/form-data" autocomplete="off">
                                @csrf

                                <!-- Input Kategori -->
                                <div class="form-group">
                                    <label for="kategori" class="form-control-label" style="font-size: smaller;">Keterangan <span style="color:red">*</span></label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                                </div>

                                 <!-- Input Skala sekar -->

                                <div class="form-group">
                                    <label for="kategori" class="form-control-label" style="font-size: smaller;">Foto Hasil Perbaikan </label>
                                    <input type="file" class="form-control" id="foto_hasil_perbaikan" name="foto_hasil_perbaikan" placeholder="Unggah Foto Hasil Perbaikan" />
                                </div>

                            </form>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary" id="btn-yes-approval">Kirim</button>
                              <div id="loading-spinner-approval" >
                                   <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!--end::Modal Validasi Crew-->
              <!-- Table with stripped rows -->
              <div class="table-responsive">
              <table class="table dt_complain responsive-table" id="datatable">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">NRP</th>
                    <th scope="col" class="hide-mobile">Nama</th>
                    <th scope="col" >Tanggal</th>
                    <th scope="col" >Batas<br>Pengerjaan</th>
                    <th scope="col" class="hide-mobile">Area</th>
                    <th scope="col" class="hide-mobile">Gedung</th>
                    <th scope="col" class="hide-mobile">Lokasi</th>
                    <th scope="col">Permasalahan</th>
                    <th scope="col">Crew Pic</th>
                    <th scope="col">Lama<br>Pengerjaan</th>
                    <th scope="col">Skala</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                {{-- //sekar --}}
                @foreach($ComplainData as $no => $complain)
                <tr>
                    <td>{{ $no + 1 }}</td>
                    <td>{{ $complain->nrp}}</td>
                    <td class="hide-mobile">{{ $complain->nama}}</td>
                    <td class="submission-date" data-submission-date="{{ $complain->tanggal }}">
                        {{ $complain->tanggal }}
                    </td>
                    <td class="due-date" data-due-date="{{ $complain->due_date }}">
                        {{ $complain->due_date }}
                    </td>
                    <td class="hide-mobile">{{ $complain->area}}</td>
                    {{-- <td class="truncate-text">{{ $complain->informasi}}</td> --}}
                    <td class="hide-mobile">{{ $complain->gedung}}</td>
                    <td class="hide-mobile">{{ $complain->lokasi}}</td>
                    <td class="truncate-text">{{ $complain->permasalahan}}</td>
                    <td>{{ $complain->crew_pic}}</td>
                    <td class="lama-pengerjaan"></td>
                    <td>{{ $complain->skala ? $complain->skala : '-' }}</td>
                    <td>
                        @if($complain->kode_status == 1)
                            <span class="badge rounded-pill text-bg-primary">Create</span>
                        @elseif($complain->kode_status == 2)
                            <span class="badge rounded-pill text-bg-info text-start">Validasi <br> GA/GL</span>
                        @elseif($complain->kode_status == 3)
                            <span class="badge rounded-pill text-bg-info text-start">Follow Up Crew</span>
                        @elseif($complain->kode_status == 4)
                            <span class="badge rounded-pill text-bg-info text-start">Waiting<br>Approval GA/GL</span>
                        @elseif($complain->kode_status == 5)
                            <span class="badge rounded-pill text-bg-info text-start">Revisi<br> to Crew</span>
                        @elseif($complain->kode_status == 6)
                            <span class="badge rounded-pill bg-danger text-start">Reject by Crew</span>
                        @elseif($complain->kode_status == 7)
                            <span class="badge rounded-pill bg-success text-light">Done</span>
                        @elseif($complain->kode_status == 8)
                            <span class="badge rounded-pill bg-danger text-start">Reject <br> by GA/GL</span>
                        @elseif($complain->kode_status == 9)
                            <span class="badge rounded-pill text-bg-warning text-start">Revisi to<br> User</span>
                        @elseif($complain->kode_status == 10)
                        <span class="badge rounded-pill text-bg-warning text-start">Pending Revisi <br> Crew </span>
                        @else
                            <span class="badge rounded-pill bg-danger">Unknown Status</span>
                        @endif
                    </td>
                    <td>
                <div class="dropdown">
                <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                @if(auth()->user()->id_role == 0)
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewComplainModal" data-id="{{ $complain->id }}"><i class="fa fa-expand"></i>View</a></li>
                    <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#complainModal" data-id="{{ $complain->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                    <li><a class="dropdown-item delete" href="#" data-id="{{ $complain->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>
                    <li><a class="dropdown-item approval" href="#" data-bs-toggle="modal"data-bs-target="#approvalModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-square-check"></i> Approve</a></li>
                    <li><a class="dropdown-item validasi" href="#" data-bs-toggle="modal" data-bs-target="#validasiModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-square-check"></i>Validasi GA/GL</a></li>
                    <li><a class="dropdown-item pendingGagl" href="#" data-bs-toggle="modal" data-bs-target="#pendingModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-message"></i>Pending GA/GL</a></li>
                    <li><a class="dropdown-item revisi" href="#" data-bs-toggle="modal" data-bs-target="#revisiModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-message"></i>Revisi</a></li>
                    <li><a class="dropdown-item reject" href="#" data-bs-toggle="modal" data-bs-target="#rejectModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-circle-xmark"></i>Reject</a></li>
                    <li><a class="dropdown-item rejectcrew" href="#" data-bs-toggle="modal" data-bs-target="#rejectCrewModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-circle-xmark"></i>Reject Crew</a></li>
                    <li><a class="dropdown-item revisicrew" href="#" data-bs-toggle="modal" data-bs-target="#revisiCrewModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-message"></i>Revisi Crew</a></li>
                    <li><a class="dropdown-item validasi_crew" href="#" data-bs-toggle="modal" data-bs-target="#validasiCrewModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-square-check"></i>Follow Up Crew</a></li>

                </ul>
                @elseif($complain->kode_status == 1 && auth()->user()->id_role == 1)
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewComplainModal" data-id="{{ $complain->id }}"><i class="fa fa-expand"></i>View</a></li>
                    <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#complainModal" data-id="{{ $complain->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                    <li><a class="dropdown-item delete" href="#" data-id="{{ $complain->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>
                </ul>
                @elseif($complain->kode_status == 1 && auth()->user()->id_role == 3)
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewComplainModal" data-id="{{ $complain->id }}"><i class="fa fa-expand"></i>View</a></li>
                    <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#complainModal" data-id="{{ $complain->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                    <li><a class="dropdown-item delete" href="#" data-id="{{ $complain->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>
                </ul>
                @elseif($complain->kode_status == 1 && auth()->user()->id_role == 2)
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewComplainModal" data-id="{{ $complain->id }}"><i class="fa fa-expand"></i>View</a></li>
                    <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#complainModal" data-id="{{ $complain->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                    <li><a class="dropdown-item delete" href="#" data-id="{{ $complain->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>
                </ul>
                @elseif($complain->kode_status == 1 && auth()->user()->id_role == 4)
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewComplainModal" data-id="{{ $complain->id }}"><i class="fa fa-expand"></i>View</a></li>
                    <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#complainModal" data-id="{{ $complain->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                    <li><a class="dropdown-item delete" href="#" data-id="{{ $complain->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>
                </ul>
                @elseif($complain->kode_status == 9 && in_array(auth()->user()->id_role, [1, 2, 3, 4]))
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewComplainModal" data-id="{{ $complain->id }}"><i class="fa fa-expand"></i>View</a></li>
                    <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#complainModal" data-id="{{ $complain->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                    <li><a class="dropdown-item delete" href="#" data-id="{{ $complain->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>
                </ul>
                @elseif($complain->kode_status == 3  && in_array(auth()->user()->id_role, [2, 4]))
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewComplainModal" data-id="{{ $complain->id }}"><i class="fa fa-expand"></i>View</a></li>
                    <li><a class="dropdown-item rejectcrew" href="#" data-bs-toggle="modal" data-bs-target="#rejectCrewModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-circle-xmark"></i>Reject Crew</a></li>
                    <li><a class="dropdown-item validasi_crew" href="#" data-bs-toggle="modal" data-bs-target="#validasiCrewModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-square-check"></i>Follow Up Crew</a></li>
                </ul>
                 @elseif($complain->kode_status == 5 && in_array(auth()->user()->id_role, [2, 4]))
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewComplainModal" data-id="{{ $complain->id }}"><i class="fa fa-expand"></i>View</a></li>
                    <li><a class="dropdown-item rejectcrew" href="#" data-bs-toggle="modal" data-bs-target="#rejectCrewModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-circle-xmark"></i>Reject Crew</a></li>
                    <li><a class="dropdown-item validasi_crew" href="#" data-bs-toggle="modal" data-bs-target="#validasiCrewModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-square-check"></i>Follow Up Crew</a></li>
                </ul>
                @elseif($complain->kode_status == 10 && in_array(auth()->user()->id_role, [2, 4]))
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewComplainModal" data-id="{{ $complain->id }}"><i class="fa fa-expand"></i>View</a></li>
                    <li><a class="dropdown-item rejectcrew" href="#" data-bs-toggle="modal" data-bs-target="#rejectCrewModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-circle-xmark"></i>Reject Crew</a></li>
                    <li><a class="dropdown-item validasi_crew" href="#" data-bs-toggle="modal" data-bs-target="#validasiCrewModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-square-check"></i>Follow Up Crew</a></li>
                </ul>
                @elseif($complain->kode_status == 2 && in_array(auth()->user()->id_role, [3, 4]))
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewComplainModal" data-id="{{ $complain->id }}"><i class="fa fa-expand"></i>View</a></li>
                    <li><a class="dropdown-item validasi" href="#" data-bs-toggle="modal" data-bs-target="#validasiModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-square-check"></i>Validasi GA/GL</a></li>
                    <li><a class="dropdown-item pendingGagl" href="#" data-bs-toggle="modal" data-bs-target="#pendingModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-message"></i>Pending GA/GL</a></li>
                    <li><a class="dropdown-item revisi" href="#" data-bs-toggle="modal" data-bs-target="#revisiModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-message"></i>Revisi</a></li>
                    <li><a class="dropdown-item reject" href="#" data-bs-toggle="modal" data-bs-target="#rejectModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-circle-xmark"></i>Reject</a></li>
                </ul>
                 @elseif($complain->kode_status == 4 && in_array(auth()->user()->id_role, [3,4]))
                 <ul class="dropdown-menu">
                    <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewComplainModal" data-id="{{ $complain->id }}"><i class="fa fa-expand"></i>View</a></li>
                    <li><a class="dropdown-item approval" href="#" data-bs-toggle="modal"data-bs-target="#approvalModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-square-check"></i> Approve</a></li>
                    <li><a class="dropdown-item revisicrew" href="#" data-bs-toggle="modal" data-bs-target="#revisiCrewModalgagl" data-id="{{ $complain->id }}"><i class="fa-regular fa-message"></i>Revisi Crew</a></li>
                </ul>
                @else
                 <ul class="dropdown-menu">
                    <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewComplainModal" data-id="{{ $complain->id }}"><i class="fa fa-expand"></i>View</a></li>
                @endif
                </div>
              </td>
              </tr>
              @endforeach
              </tbody>
              </table>
              </div>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

    {{-- <script src="app/javascript/complain.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<script>

$(document).ready(function() {
    $('.truncate-text').each(function() {
        var maxLength = 100;
        var originalText = $(this).text();

        if (originalText.length > maxLength) {
            var truncatedText = originalText.substring(0, maxLength) + '...';
            $(this).text(truncatedText);
        }
    });
});

//view
var complainId;
$('.view').click(function () {
    complainId = $(this).data('id');
    $('#viewComplainModal').attr('data-mode', 'edit');

    $.ajax({
        type: 'GET',
        // url: '{{ url('/complain/get') }}/' + complainId,
        url: '/complain/get/' + complainId,
        success: function (response) {

            function setFieldVisibility(selector, value) {
                const field = $(selector).closest('.detail');
                if (value) {
                    $(selector).text(value);
                    field.show();
                } else {
                    field.hide();
                }
            }

            // Atur visibilitas elemen berdasarkan data yang diterima
            setFieldVisibility('#nama_complain', response.nama);
            setFieldVisibility('#dept_complain', response.dept);
            setFieldVisibility('#tanggal_complain', response.tanggal);
            setFieldVisibility('#area_complain', response.area);
            setFieldVisibility('#gedung_complain', response.gedung);
            setFieldVisibility('#lokasi_complain', response.lokasi);
            setFieldVisibility('#permasalahan_complain', response.permasalahan);
            setFieldVisibility('#pending', response.pending_gagl);
            setFieldVisibility('#skala_complain', response.skala);
            setFieldVisibility('#kategori_complain', response.kategori);
            setFieldVisibility('#duedate_complain', response.due_date);
            setFieldVisibility('#crew_pic', response.crew_pic);
            setFieldVisibility('#identification_complain', response.identification);
            setFieldVisibility('#correctiveaction_complain', response.corrective_action);
            setFieldVisibility('#validasi_crew_on', response.validasi_crew_on);
            setFieldVisibility('#revisi_by_gagl', response.revisi_by);
            setFieldVisibility('#revisi_desc', response.revisi_desc_gagl);
            setFieldVisibility('#reject_by', response.reject_by);
            setFieldVisibility('#reject_desc', response.reject_desc_gagl);
            setFieldVisibility('#approval_desc', response.approval_desc);
            //new
            setFieldVisibility('#jam_kirim', response.send_on);
            setFieldVisibility('#revisi_by_crew', response.revisi_by_crew);
            setFieldVisibility('#revisi_desc_crew', response.revisi_desc_crew);
            setFieldVisibility('#reject_by_crew', response.reject_by_crew);
            setFieldVisibility('#reject_desc_crew', response.reject_desc_crew);
            function setImageVisibility(imgSelector, labelSelector, imageUrl) {

            const imgContainer = $(imgSelector);
            const label = $(labelSelector);

            if (!imageUrl) {
                imgContainer.empty();
                imgContainer.hide();
                label.hide();
            } else {
                imgContainer.html('<img src="' + imageUrl + '" alt="" class="img-fluid" />');
                imgContainer.show();
                label.show();
            }
        }

            setImageVisibility('#fotodeviasi_complain', '#label_foto_deviasi', response.foto_deviasi);
            setImageVisibility('#fotoperbaikan_complain', '#label_foto_perbaikan', response.foto_perbaikan);
            setImageVisibility('#fotohasilperbaikan_complain', '#label_foto_hasil_perbaikan', response.foto_hasil_perbaikan);


            $('#viewComplainModal').modal('show');
        },
        error: function (error) {
            console.error('Error fetching data:', error);
        }
    });
});



var complainId;
$('.edit').click(function() {
    complainId = $(this).data('id');
    $('#complainModal').attr('data-mode', 'edit');

    $.ajax({
        type: 'GET',
        url: '/complain/get/' + complainId,
        success: function(response) {
            $('#complainModal').find('#tanggal_add').val(response.tanggal);
            $('#complainModal').find('#area_add').val(response.area).trigger('change');
            setTimeout(function() {
                $('#complainModal').find('#gedung_add').val(response.gedung);
            }, 200);
            $('#complainModal').find('#lokasi_add').val(response.lokasi);
            $('#complainModal').find('#permasalahan_add').val(response.permasalahan);

            $('#complainModal').attr('data-mode', 'edit');
            $('#complainModal').modal('show');
        },
        error: function(error) {
            console.log(error);
        }
    });
});

$(document).ready(function() {
    $('#area_add').change(function() {
        const selectedArea = $(this).val();
        const gedungSelect = $('#gedung_add');

        gedungSelect.html('<option value="">Pilih Gedung</option>');

        if (selectedArea && gedungOptions[selectedArea]) {
            gedungOptions[selectedArea].forEach(function(gedung) {
                gedungSelect.append('<option value="' + gedung + '">' + gedung + '</option>');
            });

            gedungSelect.prop('disabled', false);
        } else {
            gedungSelect.prop('disabled', true);
        }
    });
});

$(document).ready(function() {
    $('#btn-yes-add').click(function() {
        var mode = $('#complainModal').data('mode');
        var formData = new FormData($('form')[0]);
        formData.append('complain_id', complainId);

        $('#btn-yes-add').hide();
        $('#loading-spinner').show();

        if (mode === 'add') {
            $.ajax({
                type: 'POST',
                url: '{{ url('/complain/create') }}',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'complain berhasil di tambahkan!',
                        }).then(() => {
                            window.location.href = window.location.href;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'complain gagal di tambahkan.',
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat mengirim data.',
                    });
                },
                complete: function() {

                    $('#btn-yes-add').show();
                    $('#loading-spinner').hide();
                }
            });
        } else if (mode === 'edit') {
            $.ajax({
                type: 'POST',
                url: '/complain/myedit/' + complainId,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'complain berhasil di edit!',
                        }).then(() => {
                            window.location.href = window.location.href; // Reload halaman
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'complain gagal di edit.',
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat mengirim data.',
                    });
                },
                complete: function() {
                    $('#btn-yes-add').show();
                    $('#loading-spinner').hide();
                }
            });
        }


    });
});

//DELETE
document.querySelectorAll('.delete').forEach(function(link) {
   link.addEventListener('click', function(event) {
       event.preventDefault();
       var complainId = this.getAttribute('data-id');

       Swal.fire({
           title: 'Konfirmasi',
           text: 'Apakah Anda yakin akan menghapus data ini?',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Ya, Kirim!',
           cancelButtonText: 'Batal'
       }).then((result) => {
           if (result.isConfirmed) {
                //    axios.post('{{ route('delete.complain') }}', {
                axios.post('/complain/delete', {
                   complain_id: complainId
               })
               .then(function (response) {
                   Swal.fire({
                       icon: 'success',
                       title: 'Sukses!',
                       text: response.data.message
                   }).then(() => {
                       location.reload();
                   });
               })
               .catch(function (error) {
                   Swal.fire({
                       icon: 'error',
                       title: 'Gagal!',
                       text: 'Terjadi kesalahan saat mengirim data.'
                   });
               });
           }
       });
   });
});

//SEND
document.querySelectorAll('.send-link').forEach(function(link) {
   link.addEventListener('click', function(event) {
       event.preventDefault();
       var complainId = this.getAttribute('data-id');

       Swal.fire({
           title: 'Konfirmasi',
           text: 'Yakin ingin mengirim data?',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Ya, Kirim!',
           cancelButtonText: 'Batal'
       }).then((result) => {
           if (result.isConfirmed) {
            //    axios.post('{{ route('send.complain') }}', {
               axios.post('/complain/send-data', {

                   complain_id: complainId
               })
               .then(function (response) {
                   Swal.fire({
                       icon: 'success',
                       title: 'Sukses!',
                       text: response.data.message
                   }).then(() => {
                       location.reload();
                   });
               })
               .catch(function (error) {
                   Swal.fire({
                       icon: 'error',
                       title: 'Gagal!',
                       text: 'Terjadi kesalahan saat mengirim data.'
                   });
               });
           }
       });
   });
});

//REVISI GAGL
$(document).ready(function() {
    $('.revisi').click(function() {
        var complainId = $(this).data('id');

        $('#btn-yes-revisi').off('click').on('click', function() { // Gunakan off().on() agar event tidak bertambah
            var data = $('.form_revisi').serialize();

            $('#btn-yes-revisi').hide();
            $('#loading-spinner').show();

            $.ajax({
                type: 'POST',
                url: '/complain/revisi?complain_id=' + complainId,
                data: data,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: response.message
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat mengirim revisi.'
                    });
                },
                complete: function() {
                    $('#btn-yes-revisi').show();
                    $('#loading-spinner').hide();
                }
            });
        });
    });
});


//REJECT GAGL
$('.reject').click(function() {
    var complainId = $(this).data('id');
    $('#btn-yes-reject').click(function() {
        var data = $('.form_reject').serialize();

        $.ajax({
            type: 'POST',
            // url: '/complain/reject?complain_id=' + complainId,
            url: '/complain/reject?complain_id=' + complainId,
            data: data,
            success: function(response) {
                Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: response.message
                }).then(() => {
                       location.reload();
                   });
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat mengirim revisi.'
                });
            }
        });
    });
});

//VALIDASI GAGL
$('.validasi').click(function() {
    var complainId = $(this).data('id');
    $('#btn-yes-validasi').click(function() {
        var data = $('.form_validasi').serialize();

        $.ajax({
            type: 'POST',
            // url: '/complain/validasigagl?complain_id=' + complainId,
            url: '/complain/validasigagl?complain_id=' + complainId,
            data: data,
            success: function(response) {
                Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: response.message
                }).then(() => {
                      location.reload();
                  });
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat mengirim data.'
                });
            }
        });
    });
});


//PENDING GAGL
$('.pendingGagl').click(function() {
    var complainId = $(this).data('id');

    $('#btn-yes-pendingGagl').click(function() {
        var data = $('.form_pendingGagl').serialize();
        $.ajax({
            type: 'POST',
            // url: '/complain/pendingGagl?complain_id=' + complainId,
            url: '/complain/pendingGagl?complain_id=' + complainId,
            data: data,
            success: function(response) {
                Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: response.message
                }).then(() => {
                       location.reload()
                });
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat mengirim revisi.'
                });
            }
        });
    });
});

// VALIDASI CREW
$(document).ready(function() {
    $('.validasi_crew').click(function() {
        var complainId = $(this).data('id');

        $('#btn-yes-validasi_crew').off('click').on('click', function() {
            var form = $('.form_validasi_crew')[0];
            var formData = new FormData(form);
            formData.append('complain_id', complainId);

            $('#btn-yes-validasi_crew').hide();
            $('#loading-spinner-validasi').show();

            $.ajax({
                type: 'POST',
                url: '/complain/validasicrew',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: response.message
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(error) {
                    var errorMessage = error.responseJSON && error.responseJSON.message
                        ? error.responseJSON.message
                        : 'Terjadi kesalahan saat mengirim validasi.';

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: errorMessage
                    });
                },
                complete: function() { // Memperbaiki kesalahan titik koma
                    $('#btn-yes-validasi_crew').show();
                    $('#loading-spinner').hide();
                }
            });
        });
    });
});

//REJECT crew
$('.rejectcrew').click(function() {
    var complainId = $(this).data('id');
    $('#btn-yes-reject_crew').click(function() {
        var data = $('.form_reject_crew').serialize();

        $.ajax({
            type: 'POST',
            url: '/complain/rejectcrew?complain_id=' + complainId,
            //url: '/complain/rejectcrew?complain_id=' + complainId,
            data: data,
            success: function(response) {
                Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: response.message
                }).then(() => {
                       location.reload();
                   });
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat mengirim revisi.'
                });
            }
        });
    });
});

//Revisi crew
$('.revisicrew').click(function() {
    var complainId = $(this).data('id');
    $('#btn-yes-revisi_crew').click(function() {
        var data = $('.form_revisi_crew').serialize();

        $.ajax({
            type: 'POST',
            //url: '/complain/revisicrew?complain_id=' + complainId,
            url: '/complain/revisicrew?complain_id=' + complainId,
            data: data,
            success: function(response) {
                Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: response.message
                }).then(() => {
                       location.reload();
                   });
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat mengirim revisi.'
                });
            }
        });
    });
});

// VALIDASI crew sekar
$('.approval').click(function() {
    var complainId = $(this).data('id');

    $('#btn-yes-approval').off('click').on('click', function() {
        var form = $('.form_approval')[0];
        var formData = new FormData(form);
        formData.append('complain_id', complainId);
        $('#btn-yes-approval').hide();
        $('#loading-spinner-approval').show();
        $.ajax({
            type: 'POST',
            url: '/complain/approval',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: response.message
                }).then(() => {
                    location.reload();
                });
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat mengirim data.'
                });
            },
                complete: function() {
                    $('#btn-yes-approval').show();
                    $('#loading-spinner').hide();
                }

        });
    });
});

function updateDueDate() {
    const skala = document.getElementById('skala').value;
    const dueDate = document.getElementById('due_date');

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    let tambahanHari = 0;
    if (skala === 'Prioritas') {
        tambahanHari = 0;
    } else if (skala === 'Minor') {
        tambahanHari = 1;
    } else if (skala === 'Mayor') {
        tambahanHari = 3;
    } else {
        dueDate.value = '';
        return;
    }

    today.setDate(today.getDate() + tambahanHari);

    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
    const dd = String(today.getDate()).padStart(2, '0');

    const formattedDate = `${yyyy}-${mm}-${dd}`;

    // Update nilai pada input due_date
    dueDate.value = formattedDate;
}



    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('due_date').value = '';
    });

    const gedungOptions = {
        'Mess': [
            'A1', 'A2', 'B1', 'B2', 'B3', 'B4', 'B7', 'B8', 'B9', 'B10','C3', 'MASJID ASSALAM', 'KOPPA MART', 'FOOD COURT', 'POS SECURITY', 'WTP', 'STP', 'GUDANG GA', 'OFFICE GA', 'WORKSHOP TRAC', 'WORKSHOP KPM', 'WASHPAD'
        ],
        'Office': [
            'WAREHOUSE', 'GENSET', 'OFFICE PLANT', 'WORKSHOP PLANT', 'KOPPA MART', 'MASJID AL KAUTSAR', 'LIMBAH B3'
        ],
        'CSA 1': [
            'OFFICE SHE', 'OFFICE AKADEMI', 'OFFICE ICT', 'CSA FUEL'
        ],
        'CSA 2': [
            'CSA OB', 'CSA HRM'
        ],
        'CSA 3': [
            'CSA OB', 'OFFICE CCR'
        ],
        'CSA FUEL': [
            'SPBI PPA'
        ],
        'PITSTOP': [
            'MUSHOLLA', 'WORKSHOP TRACK', 'AKADEMI', 'FABRIKASI', 'TOOLS', 'TYRE', 'TRACKINDO', 'SUPPORT'
        ],
        'OTHER': []
    };

    document.getElementById('area_add').addEventListener('change', function() {
        const selectedArea = this.value;
        const gedungSelect = document.getElementById('gedung_add');

        gedungSelect.innerHTML = '<option value="">Pilih Gedung</option>';

        if (selectedArea && selectedArea !== 'OTHER') {
            gedungOptions[selectedArea].forEach(gedung => {
                const option = document.createElement('option');
                option.value = gedung;
                option.textContent = gedung;
                gedungSelect.appendChild(option);
            });


            gedungSelect.disabled = false;
        } else {

            gedungSelect.disabled = true;
        }
    });


$(document).ready(function() {

    function getMaxLength() {

        if (window.matchMedia("(max-width: 576px)").matches) {
            return 10;
        }
        return 50;
    }

    $('.truncate-text').each(function() {
        var maxLength = getMaxLength();
        var originalText = $(this).text();

        if (originalText.length > maxLength) {
            var truncatedText = originalText.substring(0, maxLength) + '...';
            $(this).text(truncatedText);
        }
    });

    $(window).resize(function() {
        $('.truncate-text').each(function() {
            var maxLength = getMaxLength();
            var originalText = $(this).data('original-text') || $(this).text();

            if (originalText.length > maxLength) {
                var truncatedText = originalText.substring(0, maxLength) + '...';
                $(this).text(truncatedText).data('original-text', originalText);
            } else {
                $(this).text(originalText);
            }
        });
    });
});

$(document).ready(function() {
    $.ajax({
        url: '/complain/getteknisi',
        method: 'GET',
        success: function(response) {
            $('#crew_picadd').empty();
            $('#crew_picadd').append('<option value="">- Pilih Crew PIC -</option>');

            $.each(response, function(index, user) {
                $('#crew_picadd').append('<option value="' + user.nama + '">' + user.nama + '</option>');
            });

        },
        error: function() {
            alert('Terjadi kesalahan dalam mengambil data');
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("#datatable tbody tr").forEach(row => {
        const submissionDateCell = row.querySelector(".submission-date");
        const dueDateCell = row.querySelector(".due-date");
        const lamaPengerjaanCell = row.querySelector(".lama-pengerjaan");

        if (!submissionDateCell || !dueDateCell || !lamaPengerjaanCell) return;

        const submissionDate = submissionDateCell.getAttribute("data-submission-date");
        const dueDate = dueDateCell.getAttribute("data-due-date");

        if (!submissionDate || submissionDate.trim() === "") {
            lamaPengerjaanCell.innerHTML = `<span class="badge rounded-pill text-bg-secondary">-</span>`;
            return;
        }

        const daysWorked = calculateDaysDifference(submissionDate) + 1;
        let isLate = false;
        if (dueDate && dueDate.trim() !== "") {
            isLate = isDueDateExceeded(dueDate);
        }

        const badge = document.createElement("span");
        badge.classList.add("badge", "rounded-pill");
        badge.innerText = `${daysWorked} hari`;

        badge.classList.add(isLate ? "text-bg-danger" : "text-bg-success");
        lamaPengerjaanCell.innerHTML = "";
        lamaPengerjaanCell.appendChild(badge);
    });
});

function calculateDaysDifference(startDate) {
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const start = new Date(startDate);
    start.setHours(0, 0, 0, 0);

    return Math.floor((today - start) / (1000 * 3600 * 24));
}

function isDueDateExceeded(dueDate) {
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const due = new Date(dueDate);
    due.setHours(0, 0, 0, 0);

    return today > due;
}
$(document).ready(function() {
    $('#datatable').DataTable({
        responsive: true
    });
});




</script>

@endsection


