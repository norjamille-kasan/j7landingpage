<template>
  <div>
    <div class="flex flex-col">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300 table-fixed">
              <thead class="bg-gray-50">
                <tr>
                 <slot name="head" />
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
               <slot name="body" />
              </tbody>
            </table>
          </div>
          <div>
            <slot name="pagination" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>