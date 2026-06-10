<div class="flex items-center justify-center mt-80">
  <button class="px-4 py-2 font-serif text-xl text-white bg-gray-400 border-none rounded-full hover:bg-gray-700 focus:outline-none">Open Modal</button>
  <div class="@if($show == false) hidden @endif fixed top-0 left-0 flex items-center justify-center w-full h-full z-1">
    <div class="fixed w-full h-full bg-gray-500 opacity-50"></div>
    <div class="relative flex flex-col items-center w-3/12 p-8 mx-auto bg-white z-2 rounded-xl">
      <p class="pb-4 font-serif text-xl">Hello world, I am a free modal :)</p>
      <button class="px-4 py-2 font-serif text-xl text-white bg-red-400 border-none rounded-full hover:bg-red-700 focus:outline-none" wire:click.prevent="doClose()">Close Modal</button>
    </div>
  </div>
</div>
