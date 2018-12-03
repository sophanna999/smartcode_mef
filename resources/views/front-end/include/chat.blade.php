
    <div class="main-section">
        <div class="row border-chat">
            <div class="col-md-12 col-sm-12 col-xs-12 first-section">
                <div class="row">
                    <div class="col-md-7 col-sm-6 col-xs-6 left-first-section">
                        <p><i class="fa fa-comment-o"></i> Chat</p>
                    </div>

                    <div class="col-md-5 col-sm-7 col-xs-7 right-first-section">
                        <label class="piece" for="c1" data-head="" data-page=""><span><i class="fa fa-minus" aria-hidden="true"></i></span></label>
                        <label class="piece" for="c1" data-head="" data-page="#/chat"><span><i class="fa fa-clone" aria-hidden="true"></i></span></label>
                        <label class="piece" for="c1" data-head="" data-page=""><span><i class="fa fa-times" aria-hidden="true"></i></span></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-chat">
            <div class="col-md-12 col-sm-12 col-xs-12 second-section">
                <div class="chat-section">
                    <ul>

                        <li>
                            <div class="right-chat">
                                <img class="img-circle" src="#">
                                <p>Hello Seng Heng, pls pull code</p>
                                <span>2 min</span>
                            </div>
                        </li>
                        <li>
                            <div class="left-chat">
                                <img class="img-circle" src="#">
                                <p>Okay Sokheng thanks, I'll pull later</p>
                                <span>3 min</span>
                            </div>
                        </li>
                        <li>
                            <div class="right-chat">
                                <img class="img-circle" src="#">
                                <p>stop pull code SengHeng now I'm doing this form.</p>
                                <span>5 min</span>
                            </div>
                        </li>
                        <li>
                            <div class="left-chat">
                                <img class="img-circle" src="#">
                                <p>If you pull, form will be merge code.</p>
                                <span>10 min</span>
                            </div>
                        </li>
                        <li>
                            <div class="right-chat">
                                <img class="img-circle" src="#">
                                <p>Yes sister. It's correct, so please Sengheng</p>
                                <span>22 min</span>
                            </div>
                        </li>
                        <li>
                            <div class="left-chat">
                                <img class="img-circle" src="#">
                                <p>Okay sis!!!!, thank you so much.</p>
                                <span>2 min</span>
                            </div>
                        </li>
                        <li>
                            <div class="right-chat">
                                <img class="img-circle" src="#">
                                <p>Now I've already completed code</p>
                                <span>2 min</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row border-chat" style="background-color: #EEEEEE">
            <div class="col-md-12 col-sm-12 col-xs-12 third-section">
                <div class="text-bar">
                    <input type="text" placeholder="Write message">
                    <a href=""> <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".left-first-section").click(function(){
                $('.main-section').toggleClass("open-more");
            });
        });
        $(document).ready(function(){
            $(".fa-minus").click(function(){
                $('.main-section').toggleClass("open-more");
            });
        });
        $(function(){
            $(".chat-section").slimScroll();
        })
    </script>
