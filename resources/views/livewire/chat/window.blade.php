<div class="flex flex-col h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <x-chat.header :selectedChat="$currentChat" :chatType="$chatType" :otherUser="$otherUser" />

    <x-chat.messages-container :messages="$messages" :showLoadMoreButton="$showLoadMoreButton" :totalPages="$totalPages" />

    <x-chat.message-input :previewFile="$previewFile" />

</div>
