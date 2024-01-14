<!-- Change Password Modal -->
@foreach ($user as $key => $val)
    <div id="change_password{{ $val->id }}" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.change_password', $val->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input class="form-control" value="{{ $val->username }}" type="text" required readonly>
                                </div>
                            </div>
                            {{-- <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" value="{{ $val->email }}"
                                        type="email" required readonly>
                                </div>
                            </div> --}}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input class="form-control" id="txtPassword" name="password" type="password" required>
                                </div>
                            </div>
                            {{-- <div class="col-md-12">
                                <div class="form-group">
                                    <label>Confirm New Password</label>
                                    <input class="form-control" id="txtConfirmPassword" name="password_confirm" type="password" required>
                                </div>
                            </div> --}}
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn" id="submit_ChangePwd" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
<!-- /Change Password Modal -->
