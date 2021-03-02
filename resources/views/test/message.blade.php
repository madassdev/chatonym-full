@extends('layouts.tests') @section('content')

<p class="h3 text-danger">You are sending a message to {{$user->username}}</p>
<div class="img-placeholder col-md-3 mx-auto bg-white rounded">
    dssds
    <img id="preview" />
</div>
<div class="text-part fixed-bottom mx-2">
    <div class="flex items-center justify-between space-x-2">
        <div>
            <div
                id="imgBtn"
                class="flex items-center justify-center top-2 right-2 h-8 w-8 shadow-xl bg-gray-600 cursor-pointer hover:bg-gray-900 rounded-full"
            >
                <input
                    id="imageInput"
                    type="file"
                    class="h-0 w-0"
                    accept="image/*"
                />
                <i class="mdi mdi-camera text-white text-lg"></i>
            </div>
        </div>
        <div class="w-full">
            <textarea
                name=""
                id=""
                cols="3"
                rows="4"
                class="form-control"
                placeholder="Type a message"
            ></textarea>
        </div>
        <div class="flex flex-column space-y-2">
            <div
                id="sendBtn"
                class="flex items-center justify-center top-2 right-2 h-8 w-8 shadow-xl bg-blue-500 cursor-pointer hover:bg-blue-900 rounded-full"
            >
                <i class="mdi mdi-send text-white text-lg"></i>
            </div>
        </div>
    </div>
</div>
<!-- <button
    class="btn btn-primary"
    id="sendMsg"
    data-toggle="modal"
    data-target="#signupModal"
>
    Open
</button> -->

<div
    class="modal fade"
    id="signupModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div
            class="modal-content bg-gradient-to-br from-pink-700 to-pink-900 text-white"
        >
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel">
                    Create account
                </h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Username</label>
                            <input
                                type="text"
                                name="username"
                                class="rounded-lg form-control border-1"
                            />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Email</label>
                            <input
                                type="email"
                                name="email"
                                class="rounded-lg form-control border-1"
                            />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="rounded-lg form-control"
                        />
                    </div>
                </form>
                Thanks for your message Now create and account
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn text-gray-100 bg-red-500"
                    data-dismiss="modal"
                >
                    Close
                </button>
                <button type="button" class="btn btn-primary">
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    imgBtn = $("#imgBtn");
    button = $("#sendBtn");
    modal = $("#signupModal");
    // modal.modal();

    imgBtn.click(function (e) {
        e.stopPropagation();
        // console.log('aaa')
        $("#imageInput")[0].click();
    });

    $("#imageInput").change(function (e) {
        console.log("image selected");
        var preview = $("#preview");
        var image = event.target.files[0];
        console.log(image);
        preview.attr("src", URL.createObjectURL(image));
        preview.onload = function () {
            URL.revokeObjectURL(preview.src);
        };
    });

    button.click(function () {
        modal.modal();
    });
</script>

@endsection
