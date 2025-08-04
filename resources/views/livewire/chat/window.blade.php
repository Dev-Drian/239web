<div class="flex flex-col h-screen main-bg">
    <x-chat.header :selectedChat="$currentChat" :chatType="$chatType" :otherUser="$otherUser" />

    <x-chat.messages-container :messages="$messages" :showLoadMoreButton="$showLoadMoreButton" :totalPages="$totalPages" />

    <x-chat.message-input :previewFile="$previewFile" />

</div>
