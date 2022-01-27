<template>
  <div
    id="sidebar"
    class="w-full sm:max-w-sm p-8 bg-gray-700 text-white"
  >
    <div class="px-2 mb-12">
      <img
        src="https://i.picsum.photos/id/575/512/512.jpg?hmac=QbwYBysbuQHrAiKt2d7Emj28u3W08sNnu56-m-ZcVWo"
        alt="Profile Picture"
        class="rounded-full w-48 mx-auto mb-2"
      />
      <h1 class="text-center text-3xl font-semibold mb-2">Dev Name</h1>
      <h2 class="text-center text-xl font-light">Fullstack Developer</h2>
    </div>

    <div class="font-light text-lg px-2 mb-12">
      <h2 class="text-xl font-semibold mb-4">Contact</h2>
      <ProfileAboutItem
        text="devmail@example.com"
        icon="email"
        href="mailto:devmail@example.com"
      />
      <ProfileAboutItem
        text="+1 23 456 789"
        icon="phone"
        href="tel:+123456789"
      />
      <ProfileAboutItem
        text="Dev Town, Dev Country"
        icon="home"
      />
    </div>

    <div class="font-light text-lg px-2 mb-12">
      <h2 class="text-xl font-semibold mb-4">On the Web</h2>
      <ProfileAboutItem
        text="GitHub"
        icon="github"
        href="https://github.com"
      />
      <ProfileAboutItem
        text="LinkedIn"
        icon="linkedin"
        href="https://linkedin.com"
      />
      <ProfileAboutItem
        text="Twitter"
        icon="twitter"
        href="https://twitter.com"
      />
      <ProfileAboutItem
        text="Website"
        icon="web"
        href="https://google.com"
      />
    </div>
  </div>
</template>
