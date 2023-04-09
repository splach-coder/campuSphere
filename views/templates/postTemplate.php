<div class="new-post-con">
    <div class="box-img">
        <img src="../public/images/<?=$_SESSION['profile_pic']?>" title="profile picture" alt="profile picture">
    </div>
    <div class="input-holder">
        What's on your mind, Anas ben?
    </div>
    <button>Post it?</button>
</div>

<div class="post-modal">
    <button id="post-close-btn"><i class="fas fa-times"></i></button>
    <div class="post-container">
        <div class="wrapper">
            <section class="post">
                <header>Create post</header>
                <div class="form">
                    <div class="content">
                        <img src="../public/images/<?=$_SESSION['profile_pic']?>" alt="logo">
                        <div class="details">
                            <p>Anas ben</p>
                            <div class="privacy">
                                <i class="fas fa-user-friends"></i>
                                <span id="audience" data-value="Friends">Friends</span>
                                <i class="fas fa-caret-down"></i>
                            </div>
                        </div>
                    </div>
                    <div class="body-holder">
                        <textarea id="post_status" placeholder="What's on your mind, <?= $_SESSION['username']?>?"
                            spellcheck="false"></textarea>
                        <div class="media-area" onclick="document.getElementById('post-media-file').click()">
                            <input type="file" id="post-media-file" name="post-media-file" hidden
                                accept="image/*,video/*" multiple="true" />
                            <i class="fas fa-times" id="close-media-area"></i>
                            <i class="fa-solid fa-file-circle-plus"></i>
                            <h3>Add Photos/Videos</h3>
                            <p>or drag and drop</p>
                            <div class="slider"></div>
                        </div>
                    </div>
                    <div class="theme-emoji">
                        <img src="../public/svg/theme.svg" alt="theme">
                        <img src="../public/svg/smile.svg" alt="smile">
                    </div>
                    <div class="options">
                        <p>Add to Your Post</p>
                        <ul class="list">
                            <li><img id="add-media" src="../public/svg/gallery.svg" alt="gallery"></li>
                            <li><img src="../public/svg/tag.svg" alt="gallery"></li>
                            <li><img src="../public/svg/emoji.svg" alt="gallery"></li>
                            <li><img src="../public/svg/mic.svg" alt="gallery"></li>
                            <li><img src="../public/svg/more.svg" alt="gallery"></li>
                        </ul>
                    </div>
                    <button id="post-button">Post</button>
                </div>
            </section>
            <section class="audience">
                <header>
                    <div class="arrow-back"><i class="fas fa-arrow-left"></i></div>
                    <p>Select Audience</p>
                </header>
                <div class="content">
                    <p>Who can see your post?</p>
                    <span>Your post will show up in News Feed, on your profile and in search results.</span>
                </div>
                <ul class="list">
                    <li data-value="Public">
                        <div class="column">
                            <div class="icon"><i class="fas fa-globe-asia"></i></div>
                            <div class="details">
                                <p>Public</p>
                                <span>Anyone on or off Facebook</span>
                            </div>
                        </div>
                        <div class="radio"></div>
                    </li>
                    <li data-value="Friends" class="active">
                        <div class="column">
                            <div class="icon"><i class="fas fa-user-friends"></i></div>
                            <div class="details">
                                <p>Friends</p>
                                <span>Your friends on Facebook</span>
                            </div>
                        </div>
                        <div class="radio"></div>
                    </li>
                    <li data-value="Specific">
                        <div class="column">
                            <div class="icon"><i class="fas fa-user"></i></div>
                            <div class="details">
                                <p>Specific</p>
                                <span>Only show to some friends</span>
                            </div>
                        </div>
                        <div class="radio"></div>
                    </li>
                    <li data-value="Only me">
                        <div class="column">
                            <div class="icon"><i class="fas fa-lock"></i></div>
                            <div class="details">
                                <p>Only me</p>
                                <span>Only you can see your post</span>
                            </div>
                        </div>
                        <div class="radio"></div>
                    </li>
                    <li data-value="Custom">
                        <div class="column">
                            <div class="icon"><i class="fas fa-cog"></i></div>
                            <div class="details">
                                <p>Custom</p>
                                <span>Include and exclude friends</span>
                            </div>
                        </div>
                        <div class="radio"></div>
                    </li>
                </ul>
            </section>
        </div>
    </div>
</div>
