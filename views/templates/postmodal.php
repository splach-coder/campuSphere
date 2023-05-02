<div class="post-content-modal col">
    <div class="container mt-5 mb-5" style="background: transparent;">
        <div class="d-flex justify-content-center row">
            <div class="d-flex flex-column col-md-8">
                <div class="d-flex flex-row align-items-center text-left comment-top p-2 bg-white border-bottom px-4">
                    <div class="profile-image me-2"><img class="rounded-circle" id="post-image-author" src=""
                            width="70"></div>

                    <div class="d-flex flex-column ml-3 w-100">
                        <div class="d-flex flex-row post-title justify-content-between">
                            <span class="ml-2 ms-2" id="post-username-author">(Jesshead)</span>
                            <i class="fas fa-close" id="close-comments-modal" style="cursor: pointer;"></i>
                        </div>
                        <div class="d-flex flex-row align-items-center align-content-center post-title"><span
                                class="mr-2 comments"><span id="comments-number"></span> &nbsp;</span><span
                                class="mr-2 dot"></span><span id="post-date-modal">6 hours ago</span>
                        </div>
                    </div>
                </div>
                <div class="coment-bottom bg-white p-2 px-4 mb-5" data-post-id="" id="comments-" style="
    overflow-y: scroll;
    max-height: 595px;">
                    <div class="d-flex flex-row add-comment-section mt-4 mb-4">
                        <img class="img-fluid img-responsive rounded-circle mr-2 me-2"
                            src="../public/images/<?= $_SESSION['profile_pic'] ?>" width="38">
                        <input type="text" class="form-control mr-3" placeholder="Add comment">
                        <button class="btn btn-primary ms-1 addCommentInsideModal" type="button">Comment</button>
                    </div>

                    <div class="commented-section mt-2">
                        <div class="d-flex flex-row align-items-center commented-user">
                            <img class="img-fluid img-responsive rounded-circle mr-2 me-2"
                                src="../public/images/<?= $_SESSION['profile_pic'] ?>" width="32">
                            <h5 class="mr-2">Corey oates</h5><span class="dot mb-1"></span><span class="mb-1 ml-2">4
                                hours ago</span>
                        </div>
                        <div class="comment-text-sm"><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                                do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                consequat.</span></div>
                        <div class="reply-section">
                            <div class="d-flex flex-row align-items-center voting-icons"><i
                                    class="fa fa-sort-up fa-2x mt-3 hit-voting"></i><i
                                    class="fa fa-sort-down fa-2x mb-3 hit-voting"></i><span class="ml-2">10</span><span
                                    class="dot ml-2"></span>
                                <h6 class="ml-2 mt-1">Reply</h6>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="commented-section mt-2">
                        <div class="d-flex flex-row align-items-center commented-user">
                            <h5 class="mr-2">Samoya Johns</h5><span class="dot mb-1"></span><span class="mb-1 ml-2">5
                                hours ago</span>
                        </div>
                        <div class="comment-text-sm"><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                                do eiusmod tempor incididunt ut labore et dolore magna aliqua..</span></div>
                        <div class="reply-section">
                            <div class="d-flex flex-row align-items-center voting-icons"><i class="fa fa-sort-up fa-2x mt-3 hit-voting"></i><i class="fa fa-sort-down fa-2x mb-3 hit-voting"></i><span class="ml-2">15</span><span class="dot ml-2"></span>
                                <h6 class="ml-2 mt-1">Reply</h6>
                            </div>
                        </div>
                    </div>
                    <div class="commented-section mt-2">
                        <div class="d-flex flex-row align-items-center commented-user">
                            <h5 class="mr-2">Makhaya andrew</h5><span class="dot mb-1"></span><span class="mb-1 ml-2">10
                                hours ago</span>
                        </div>
                        <div class="comment-text-sm"><span>Nunc sed id semper risus in hendrerit gravida rutrum. Non
                                odio euismod lacinia at quis risus sed. Commodo ullamcorper a lacus vestibulum sed arcu
                                non odio euismod. Enim facilisis gravida neque convallis a. In mollis nunc sed id.
                                Adipiscing elit pellentesque habitant morbi tristique senectus et netus. Ultrices mi
                                tempus imperdiet nulla malesuada pellentesque.</span></div>
                        <div class="reply-section">
                            <div class="d-flex flex-row align-items-center voting-icons"><i class="fa fa-sort-up fa-2x mt-3 hit-voting"></i><i class="fa fa-sort-down fa-2x mb-3 hit-voting"></i><span class="ml-2">25</span><span class="dot ml-2"></span>
                                <h6 class="ml-2 mt-1">Reply</h6>
                            </div>
                        </div>
                    </div>
                    <div class="commented-section mt-2">
                        <div class="d-flex flex-row align-items-center commented-user">
                            <h5 class="mr-2">Makhaya andrew</h5><span class="dot mb-1"></span><span class="mb-1 ml-2">10
                                hours ago</span>
                        </div>
                        <div class="comment-text-sm"><span>Nunc sed id semper risus in hendrerit gravida rutrum. Non
                                odio euismod lacinia at quis risus sed. Commodo ullamcorper a lacus vestibulum sed arcu
                                non odio euismod. Enim facilisis gravida neque convallis a. In mollis nunc sed id.
                                Adipiscing elit pellentesque habitant morbi tristique senectus et netus. Ultrices mi
                                tempus imperdiet nulla malesuada pellentesque.</span></div>
                        <div class="reply-section">
                            <div class="d-flex flex-row align-items-center voting-icons"><i class="fa fa-sort-up fa-2x mt-3 hit-voting"></i><i class="fa fa-sort-down fa-2x mb-3 hit-voting"></i><span class="ml-2">25</span><span class="dot ml-2"></span>
                                <h6 class="ml-2 mt-1">Reply</h6>
                            </div>
                        </div>
                        <div class="replies">
                            <h6 class="ml-2 mt-1">replies</h6>
                            <div class="d-flex flex-row align-items-center commented-user">
                                <h5 class="mr-2">Makhaya andrew</h5><span class="dot mb-1"></span><span class="mb-1 ml-2">10 hours ago</span>
                            </div>
                            <div class="comment-text-sm"><span>Nunc sed id semper risus in hendrerit gravida rutrum. Non
                                    odio euismod lacinia at quis risus sed. Commodo ullamcorper a lacus vestibulum sed
                                    arcu non odio euismod. Enim facilisis gravida neque convallis a. In mollis nunc sed
                                    id. Adipiscing elit pellentesque habitant morbi tristique senectus et netus.
                                    Ultrices mi tempus imperdiet nulla malesuada pellentesque.</span></div>
                            <div class="reply-section">
                                <div class="d-flex flex-row align-items-center voting-icons">
                                    <div class="fas fa-heart"></div>

                                    <span class="ml-2">25</span><span class="dot ml-2"></span>
                                    <div class="d-flex flex-row add-comment-section mt-4 mb-4"><input type="text" class="form-control mr-3" placeholder="Add comment"><button class="btn btn-primary ms-1" type="button">Comment</button></div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
