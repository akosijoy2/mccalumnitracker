<?php require_once 'navbar_php_script.php'; ?>





<nav>

    <div class="nav-left">

        <img src="../images/logo/alumni_logo.png" class="logo">

        <div class="search-box">

            <img src="../images/search.png">

            <input type="text" id="myInput" placeholder="Search" autocomplete="off">

            <div id="autocomplete-list" class="autocomplete-items"></div>

        </div>

    </div>




    <div class="nav-center">

        <ul>

            <a href="index.php" class="<?php echo isActive('index.php') ? 'line-bottom-visited' : ''; ?>">

                <li class="line1 <?php echo isActive('index.php') ? 'border-line-bottom' : ''; ?>">

                    <img src="../images/logo/home1.png" alt="">

                </li>

            </a>

            <a href="view_news.php" class="<?php echo isActive('news') ? 'line-bottom-visited' : ''; ?>">

                <li class="line1 <?php echo isActive('news') ? 'border-line-bottom' : ''; ?>">

                    <img src="../images/logo/newspaper.png" alt="">

                </li>

            </a>

            <a href="event_view.php" class="<?php echo isActive('event') ? 'line-bottom-visited' : ''; ?>">

                <li class="line1 <?php echo isActive('event') ? 'border-line-bottom' : ''; ?>">

                    <img src="../images/logo/calendar.png" alt="">

                </li>

            </a>

            <a href="job_view.php" class="<?php echo isActive('job') ? 'line-bottom-visited' : ''; ?>">

                <li class="line1 <?php echo isActive('job') ? 'border-line-bottom' : ''; ?>">

                    <img src="../images/logo/suitcase.png" alt="">

                </li>

            </a>

            <a href="forum.php" class="<?php echo isActive('forum') ? 'line-bottom-visited' : ''; ?>">

                <li class="line1 <?php echo isActive('forum') ? 'border-line-bottom' : ''; ?>">

                    <img src="../images/logo/chat.png" alt="">

                </li>

            </a>

            <a href="view_gallery.php" class="<?php echo isActive('gallery') ? 'line-bottom-visited' : ''; ?>">

                <li class="line1 <?php echo isActive('gallery') ? 'border-line-bottom' : ''; ?>">

                    <img src="../images/logo/photo-gallery.png" alt="">

                </li>

            </a>

            <a href="view_survey.php" class="<?php echo isActive('survey') ? 'line-bottom-visited' : ''; ?>">

                <li class="line1 <?php echo isActive('survey') ? 'border-line-bottom' : ''; ?>">

                    <img src="../images/logo/research.png" alt="">

                </li>

            </a>

        </ul>

    </div>

    <div class="nav-right">

        <ul>

            <div class="background-circle">

                <div class="message-icon" onclick="messageMenuToggle(event)">

                    <img src="../images/logo/messenger_black.png" alt="">

                    <div class="message-count"></div>

                </div>

            </div>





            <div class="background-circle">
                <div class="notification-icon" onclick="notificationMenuToggle()">
                    <img src="../images/logo/bell_black.png" alt="">
                    <div class="notification-count" data-count="<?php echo $new_notification_count; ?>"></div>
                </div>
            </div>





            <div class="background-circle">

            </div>

        </ul>




        <div class="nav-user-icon online" onclick="settingsMenuToggle()">

            <?php

            if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {

                $user_id = $_SESSION['user']['id'];

                $user_data = $alumni_data[$user_id];

                $profile_url = isset($user_data['profile_url']) ? $user_data['profile_url'] : '../images/profile.jpg';

                echo '<img src="' . $profile_url . '" alt="Profile Picture" onerror="if (this.src != \'uploads/profile.jpg\') this.src = \'uploads/profile.jpg\';">';

            }

            ?>

        </div>

    </div>




    <!------------------SETTINGS MENU------------------>

    <div class="settings-menu">

        <div id="dark-btn">

            <span></span>

        </div>




        <div class="settings-menu-inner">

            <div class="user-profile">

                <?php

                if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {

                    $user_id = $_SESSION['user']['id'];

                    $user_data = $alumni_data[$user_id];

                    $profile_url = isset($user_data['profile_url']) ? $user_data['profile_url'] : 'upload/profile.jpg';

                    $full_name = $user_data['firstname'] . ' ' . $user_data['lastname'];

                    echo '<img src="' . $profile_url . '" alt="Profile Picture" onerror="if (this.src != \'uploads/profile.jpg\') this.src = \'uploads/profile.jpg\';">';




                    echo '<div class="">';

                    echo '<p>' . $full_name . '</p>';

                    echo '<a href="view_profile.php">See your profile</a>';

                    echo '</div>';

                } else {

                    echo '<img src="upload/default-pp.png" alt="Default Profile Picture">';

                    echo '<div class="">';

                    echo '<p>Guest User</p>';

                    echo '<a href="login.php">Login to see your profile</a>';

                    echo '</div>';

                }

                ?>

            </div>

            <hr>

            <div class="settings-links">

                <img src="../images/setting.png" class="settings-icon">

                <a href="profile_overview.php">Settings<img src="../images/arrow.png" width="10px"></a>

            </div>

            <!--<div class="settings-links">

                <img src="../images/help.png" class="settings-icon">

                <a href="">Help & Support <img src="../images/arrow.png" width="10px"></a>

            </div>

            <div class="settings-links">

                <img src="../images/display.png" class="settings-icon">

                <a href="">Display & Access <img src="../images/arrow.png" width="10px"></a>

            </div> -->

            <div class="settings-links">

                <img src="../images/logout.png" class="settings-icon">

                <a href="../logout.php">Logout <img src="../images/arrow.png" width="10px"></a>

            </div>

        </div>

    </div>




    <!------------NOTIFICATION-------------------->

    <div class="notification-menu">

        <div class="notification-menu-inner">

            <h3>Notifications</h3>

            <?php if (!empty($notifications)): ?>

                <?php foreach ($notifications as $notification): ?>

                    <div class="notification-item" data-href="<?php

                    switch ($notification['type']):

                        case 'reply':

                        case 'reaction':

                            switch ($notification['content_type']):

                                case 'news':

                                    echo htmlspecialchars('visit_news.php?id=' . $notification['news_id'] . '#comment-' . $notification['comment_id']);

                                    break;

                                case 'job':

                                    echo htmlspecialchars('visit_job.php?id=' . $notification['job_id'] . '#comment-' . $notification['comment_id']);

                                    break;

                                case 'event':

                                    echo htmlspecialchars('visit_event.php?id=' . $notification['event_id'] . '#comment-' . $notification['comment_id']);

                                    break;

                                default:

                                    echo htmlspecialchars($notification['content_type'] . '.php?id=' . $notification[$notification['content_type'] . '_id'] . '#comment-' . $notification['comment_id']);

                            endswitch;

                            break;

                        case 'forum_post_reaction':

                            echo htmlspecialchars('forum.php?id=' . $notification['post_id']);

                            break;

                        case 'forum_comment':

                        case 'forum_reply':

                        case 'forum_comment_reaction':

                            echo htmlspecialchars('forum.php?id=' . $notification['post_id'] . '#comment-' . $notification['comment_id']);

                            break;

                        case 'admin_job':

                            echo htmlspecialchars('visit_job.php?id=' . $notification['id']);

                            break;

                        case 'admin_event':

                        case 'event_invitation':

                            echo htmlspecialchars('visit_event.php?id=' . $notification['id']);

                            break;

                        case 'admin_news':

                            echo htmlspecialchars('visit_news.php?id=' . $notification['id']);

                            break;

                        case 'admin_gallery':

                            echo htmlspecialchars('view_gallery.php?id=' . $notification['id']);

                            break;

                        default:

                            echo '#';

                    endswitch;

                    ?>">

                        <?php

                        // Determine image source based on notification type 
                
                        switch ($notification['type']):

                            case 'reply':

                                $imageSrc = $notification['replier_profile'] ?? '../images/logo/notification.png';

                                break;

                            case 'reaction':

                            case 'forum_post_reaction':

                            case 'forum_comment_reaction':

                                $imageSrc = $notification['reactor_profile'] ?? '../images/logo/notification.png';

                                break;

                            case 'forum_comment':

                                $imageSrc = $notification['commenter_profile'] ?? '../images/logo/notification.png';

                                break;

                            case 'forum_reply':

                                $imageSrc = $notification['replier_profile'] ?? '../images/logo/notification.png';

                                break;

                            case 'admin_job':

                                $imageSrc = '../images/logo/suitcase.png';

                                break;

                            case 'admin_event':

                            case 'event_invitation':

                                $imageSrc = '../images/logo/calendar.png';

                                break;

                            case 'admin_news':

                                $imageSrc = '../images/logo/newspaper.png';

                                break;

                            case 'admin_gallery':

                                $imageSrc = '../images/logo/photo-gallery.png';

                                break;

                            default:

                                $imageSrc = '../images/logo/notification.png';

                        endswitch;

                        ?>

                        <img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="Notification Icon">




                        <div class="notification-info">

                            <p>

                                <?php

                                switch ($notification['type']):

                                    case 'reply':

                                        echo '<strong>' . htmlspecialchars($notification['replier_name']) . '</strong> replied to your comment on a ' . htmlspecialchars($notification['content_type']);

                                        break;

                                    case 'reaction':

                                        echo '<strong>' . htmlspecialchars($notification['reactor_name']) . '</strong> reacted to your comment on a ' . htmlspecialchars($notification['content_type']);

                                        break;

                                    case 'forum_post_reaction':

                                        echo '<strong>' . htmlspecialchars($notification['reactor_name']) . '</strong> reacted with ' . htmlspecialchars($notification['reaction_type']) . ' to your forum post';

                                        break;

                                    case 'forum_comment':

                                        echo '<strong>' . htmlspecialchars($notification['commenter_name']) . '</strong> commented on your forum post';

                                        break;

                                    case 'forum_reply':

                                        echo '<strong>' . htmlspecialchars($notification['replier_name']) . '</strong> replied to your comment in a forum';

                                        break;

                                    case 'forum_comment_reaction':

                                        echo '<strong>' . htmlspecialchars($notification['reactor_name']) . '</strong> reacted to your comment in a forum';

                                        break;

                                    case 'admin_job':

                                        echo 'New job posting: <strong>' . htmlspecialchars($notification['title']) . '</strong>';

                                        break;

                                    case 'admin_event':

                                        echo 'New event: <strong>' . htmlspecialchars($notification['title']) . '</strong>';

                                        break;

                                    case 'admin_news':

                                        echo 'New news article: <strong>' . htmlspecialchars($notification['title']) . '</strong>';

                                        break;

                                    case 'admin_gallery':

                                        echo 'New gallery album: <strong>' . htmlspecialchars($notification['title']) . '</strong>';

                                        break;

                                    case 'event_invitation':

                                        echo 'You\'re invited to the event: <strong>' . htmlspecialchars($notification['title']) . '</strong>';

                                        break;

                                    default:

                                        echo 'New notification: <strong>' . htmlspecialchars($notification['title']) . '</strong>';

                                endswitch;

                                ?>

                            </p>

                            <span
                                class="notification-time"><?php echo htmlspecialchars(getTimeAgo($notification['date'])); ?></span>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <p class="no-notifications">No new notifications</p>

            <?php endif; ?>

            <a href="all_notifications.php" class="view-all-notifications">View All Notifications</a>

        </div>

    </div>





    <!----------MESSAGE-------------->





    <div class="message-menu" id="messageMenu">

        <div class="message-menu-inner">

            <div class="message-header">

                <h3>Messages</h3>

            </div>

            <hr>

            <div class="message-items-container" id="messageItemsContainer">

                <!-- Messages will be dynamically loaded here -->

            </div>

            <a href="view_all_messages.php" class="view-all-messages">View All Messages</a>

        </div>

    </div>




</nav>




<script>

    var settingsmenu = document.querySelector(".settings-menu");

    var darkBtn = document.getElementById("dark-btn");




    function settingsMenuToggle() {

        settingsmenu.classList.toggle("settings-menu-height");

    }

    darkBtn.onclick = function () {

        darkBtn.classList.toggle("dark-btn-on");

        document.body.classList.toggle("dark-theme");




        if (localStorage.getItem("theme") == "light") {

            localStorage.setItem("theme", "dark");

        } else {

            localStorage.setItem("theme", "light");

        }





    }




    if (localStorage.getItem("theme") == "light") {

        darkBtn.classList.remove("dark-btn-on");

        document.body.classList.remove("dark-theme");

    } else if (localStorage.getItem("theme") == "dark") {

        darkBtn.classList.add("dark-btn-on");

        document.body.classList.add("dark-theme");

    } else {

        localStorage.setItem("theme", "dark");

    }




</script>





<script>

    // Use PHP to inject alumni info into JavaScript 

    const alumniInfo = <?php echo $alumni_info_json; ?>;




    const input = document.getElementById("myInput");

    const autocompleteList = document.getElementById("autocomplete-list");




    input.addEventListener("input", function () {

        const value = this.value.toLowerCase();

        autocompleteList.innerHTML = "";




        if (!value) return;




        const matchingAlumni = alumniInfo.filter(alumni =>

            alumni.name.toLowerCase().includes(value)

        ).slice(0, 5); // Limit to 5 results 




        matchingAlumni.forEach(alumni => {

            const div = document.createElement("div");

            div.className = "autocomplete-item";

            div.innerHTML = ` 

                    <img src="${alumni.profile_url}" alt="${alumni.name}" > 

                    <div class="autocomplete-item-info"> 

                        <span class="autocomplete-item-name">${alumni.name}</span> 

                        <span class="autocomplete-item-details">Alumni</span> 

                    </div> 

                `;

            div.addEventListener("click", function () {

                input.value = alumni.name;

                autocompleteList.innerHTML = "";

                // Redirect to the alumni's profile 

                window.location.href = `view_alumni_details.php?id=${alumni.id}`;

            });

            autocompleteList.appendChild(div);

        });

    });




    document.addEventListener("click", function (e) {

        if (e.target !== input) {

            autocompleteList.innerHTML = "";

        }

    });




    // Add event listener for Enter key press 

    input.addEventListener("keypress", function (event) {

        if (event.key === "Enter") {

            event.preventDefault();

            const searchQuery = input.value.trim();

            if (searchQuery) {

                window.location.href = `search_results.php?query=${encodeURIComponent(searchQuery)}`;

            }

        }

    });

</script>




<script>

    document.addEventListener("DOMContentLoaded", function () {
        var notificationIcon = document.querySelector(".notification-icon");
        var notificationMenu = document.querySelector(".notification-menu");
        var notificationCount = document.querySelector(".notification-count");

        function resetNotificationCount() {
            if (notificationCount) {
                notificationCount.textContent = '';
                notificationCount.classList.remove('show');

                fetch('update_notification_check.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ user_id: '<?php echo $current_user_id; ?>' }),
                });
            }
        }

        if (notificationIcon && notificationMenu) {
            notificationIcon.addEventListener("click", function (event) {
                event.stopPropagation();
                notificationMenu.classList.toggle("notification-menu-height");
                resetNotificationCount();
            });

            document.addEventListener("click", function (event) {
                if (!event.target.closest('.notification-icon') && !event.target.closest('.notification-menu')) {
                    notificationMenu.classList.remove("notification-menu-height");
                }
            });
        }

        checkNewNotifications();
        setInterval(checkNewNotifications, 5000);
    });

    function updateNotificationCount(count) {
        const countElement = document.querySelector('.notification-count');
        if (countElement) {
            if (count > 0) {
                countElement.textContent = count;
                countElement.classList.add('show');
            } else {
                countElement.textContent = '';
                countElement.classList.remove('show');
            }
        }
    }

    function checkNewNotifications() {
        fetch('check_new_notifications.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ user_id: '<?php echo $current_user_id; ?>' }),
        })
            .then(response => response.json())
            .then(data => {
                console.log('New notifications count:', data.new_count);
                updateNotificationCount(data.new_count);
            })
            .catch(error => console.error('Error:', error));
    }

</script>




<script>

    document.querySelectorAll('.notification-item').forEach(item => {

        item.addEventListener('click', () => {

            const url = item.getAttribute('data-href');

            if (url) {

                window.location.href = url;

            }

        });

    });

</script>






<script>

    function messageMenuToggle(event) {

        var menu = document.getElementById('messageMenu');

        menu.classList.toggle('message-menu-height');




        // Send AJAX request to update message_active status 

        if (menu.classList.contains('message-menu-height')) {

            updateMessageStatus(1); // Mark as read 

        }




        // Stop the event from bubbling up to the document click event 

        event.stopPropagation();

    }




    // Close the chatbox if clicking outside of it 

    document.addEventListener('click', function (event) {

        var menu = document.getElementById('messageMenu');

        var icon = document.querySelector('.message-icon');




        if (menu.classList.contains('message-menu-height') &&

            !menu.contains(event.target) &&

            !icon.contains(event.target)) {

            menu.classList.remove('message-menu-height');

        }

    });

</script>





<script>

    // Function to fetch and update message count 

    function updateMessageCount() {

        fetch('get_message_count.php')

            .then(response => response.json())

            .then(data => {

                const messageCountElement = document.querySelector('.message-count');

                if (data.message_count > 0) {

                    messageCountElement.textContent = data.message_count;

                } else {

                    messageCountElement.textContent = '';

                }

            })

            .catch(error => console.error('Error fetching message count:', error));

    }




    // Refresh the message count every 5 seconds 

    setInterval(updateMessageCount, 5000);




    // Initial load 

    updateMessageCount();

</script>




<script>

    document.addEventListener("DOMContentLoaded", function () {
        var globalChatbox = document.getElementById('globalchatbox');
        var chatboxBody = document.querySelector('.chatbox-body');
        var chatboxInput = document.getElementById('chatbox-input');
        var sendMessageIcon = document.getElementById('send-message');
        var messageItemsContainer = document.getElementById('messageItemsContainer');
        var currentOpenChatUserId = null; // Track the currently open chat user ID
        let allMessages = []; // Store all messages for chatbox
        let latestMessages = []; // Store only the latest messages for the message menu

        function fetchMessages() {
            fetch('fetch_messages.php')
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error:', data.error);
                        return;
                    }

                    // Store messages separately
                    allMessages = data.messages; // All conversation messages for the chatbox
                    latestMessages = data.latest_messages; // Only the latest message from each sender for the message menu

                    // Update the message menu
                    updateMessageMenu(latestMessages);

                    // Update the chatbox if a chat is open
                    if (currentOpenChatUserId !== null) {
                        refreshOpenChat(); // Refresh chatbox for the currently open chat
                    }
                })
                .catch(error => console.error('Error fetching messages:', error));
        }

        function updateMessageMenu(latestMessages) {
            messageItemsContainer.innerHTML = ''; // Clear existing messages in the menu

            if (latestMessages.length === 0) {
                messageItemsContainer.innerHTML = '<div class="no-messages">No new messages.</div>';
            } else {
                latestMessages.forEach(message => {
                    const messageItem = document.createElement('div');
                    messageItem.className = 'message-item';
                    messageItem.setAttribute('data-message-id', message.messageId); // Store message ID in a data attribute

                    messageItem.innerHTML = `
                    <img src="${message.profilePic}" alt="${message.name}">
                    <div class="message-info">
                        <p><strong>${message.name}:</strong> ${message.content}</p>
                        <span class="message-time">${message.timeAgo}</span>
                    </div>
                `;

                    messageItem.addEventListener('click', function () {
                        openChat(message.userId, message.name);

                        // Send request to mark all messages as read for this conversation
                        markMessageAsRead(message.userId); // Send receiverId
                    });

                    messageItemsContainer.appendChild(messageItem);
                });
            }
        }

        function markMessageAsRead(receiverId) {
            fetch('mark_message_read.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `receiver_id=${receiverId}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(data.message);
                    } else {
                        console.error('Failed to mark messages as read:', data.error);
                    }
                })
                .catch(error => {
                    console.error('Error marking messages as read:', error);
                });
        }

        function openChat(userId, userName) {
            console.log("Opening chat for user:", userId, userName);
            const currentUserId = "<?php echo $_SESSION['user']['id']; ?>";

            // Track the currently open chat user ID
            currentOpenChatUserId = userId;

            // Update chatbox header with user's name
            document.querySelector('.chatbox-name').textContent = userName;

            // Clear previous chat content
            chatboxBody.innerHTML = '';

            // Populate chatbox with messages for this conversation
            refreshOpenChat();

            // Show the chatbox with a sliding effect
            globalChatbox.style.bottom = '0px';

            // Set a custom attribute for the active chat receiver ID
            globalChatbox.setAttribute('data-receiver-id', userId);
        }

        function refreshOpenChat() {
            const currentUserId = "<?php echo $_SESSION['user']['id']; ?>";

            if (currentOpenChatUserId === null) return; // No chat is open

            // Filter messages for the selected conversation
            const filteredMessages = allMessages.filter(message =>
                (message.senderId === currentUserId && message.receiverId === currentOpenChatUserId) ||
                (message.senderId === currentOpenChatUserId && message.receiverId === currentUserId)
            );

            // Clear chatbox body
            chatboxBody.innerHTML = '';

            // Populate chatbox with filtered messages
            filteredMessages.forEach(function (message) {
                var messageDiv = document.createElement('div');
                messageDiv.className = message.senderId === currentUserId ? 'message outgoing' : 'message incoming';
                messageDiv.innerHTML = `
                <p>${message.content}</p>
                <span class="timestamp">${message.timeAgo}</span>
            `;
                chatboxBody.appendChild(messageDiv);
            });

            // Scroll to the bottom of the chatbox to show the latest message
            chatboxBody.scrollTop = chatboxBody.scrollHeight;
        }

        // Fetch messages immediately when the page loads
        fetchMessages();

        // Then fetch messages every 5 seconds
        setInterval(fetchMessages, 5000);

        // Close chatbox functionality
        document.querySelector('.close-chat').addEventListener('click', function () {
            globalChatbox.style.bottom = '-500px'; // Hide the chatbox with a sliding effect
            currentOpenChatUserId = null; // Reset the current open chat user ID
        });

        // Send message functionality
        sendMessageIcon.addEventListener('click', sendMessage);

        chatboxInput.addEventListener('keypress', function (event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        });

        function sendMessage() {
            var messageContent = chatboxInput.value.trim();
            if (messageContent === '') {
                return; // Do not send empty messages
            }

            var receiverId = globalChatbox.getAttribute('data-receiver-id');
            var currentUserId = "<?php echo $_SESSION['user']['id']; ?>";
            var timestamp = new Date().toISOString();

            // Create message data
            var messageData = {
                senderId: currentUserId,
                receiverId: receiverId,
                content: messageContent,
                timestamp: timestamp
            };

            // Send message using AJAX
            fetch('send_message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(messageData)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Append the message to the chatbox
                        var messageDiv = document.createElement('div');
                        messageDiv.className = 'message outgoing';
                        messageDiv.innerHTML = `
                        <p>${messageContent}</p>
                        <span class="timestamp">${formatTimestamp(new Date(timestamp))}</span>
                    `;
                        chatboxBody.appendChild(messageDiv);

                        // Clear the input field
                        chatboxInput.value = '';
                        chatboxBody.scrollTop = chatboxBody.scrollHeight; // Scroll to the bottom

                        // Fetch messages to update the list
                        fetchMessages();
                    } else {
                        alert('Failed to send message: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                    alert('An error occurred while sending the message.');
                });
        }

        // Format timestamp to more readable format
        function formatTimestamp(date) {
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            var strTime = hours + ':' + minutes + ' ' + ampm;
            return strTime;
        }
    });


</script>