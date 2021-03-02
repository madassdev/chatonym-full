@extends('layouts.tests')

@section('content')

<div class="col-md-12 relative mx-auto">
    <div class="row">
        <div class="flex col-md-12 justify-between items-center border-b border-gray-700 p-2">
            <p class="h3 text-white">Feeds</p>
            <button class="btn btn-success fixed-bottom transition duration-150 ease-in-out " id="showFeedsBtn">Show feeds</button>
        </div>
        <div class="p-2 feeds col-md-12" id="feedsContainer">
            <p class="text-xs text-gray-400">
                Feeds will show here
            </p>
        </div>
        <div id="spinner-container" class="p-2 absolute flex w-full items-center justify-center col-md-12 z-10 -bottom-8">
            <div class="spinner-border text-red-900 mx-auto" id="spinner" role="status"></div>
        </div>
    </div>
</div>

<script>
    var currentPage = 16
    var endPage = false
    var feedsUi = $('#feedsContainer')
    var url = "https://anonymous.dv/api/feeds";
    var feeds = []
    var spinner = $("#spinner")
    var spinnerContainer = $("#spinner-container")
    // spinner.hide()

    function generateFeedUi(feed) {
        content = `
        <div class="feed transition duration-500 ease-in-out card my-3 bg-gradient-to-br from-pink-700 to-red-900 text-white p-3 hidden">
            <p class="font-semibold">
                ${feed.message}
            </p>
            <div class="info flex space-x-4 col-md-3 justify-between mt-2 text-gray-200 text-sm">
                <div class="likes">
                    <i class="mdi mdi-heart-outline"></i>
                    ${feed.reactions_count}
                </div>

                <div class="comments">
                    <i class="mdi mdi-comment-text-multiple-outline"></i>
                    ${feed.replies}
                </div>

            </div>
        </div>
        `
        return content
    }

    async function fetchFeeds() {

        await $.get(url, function(data, status) {
            console.log(data)
            feeds = data.data.feeds.data
            url = data.data.feeds.next_page_url
            console.log(url)
        })

    }

    $("#showFeedsBtn").click(function() {
        currentPage++;
        showFeeds()
    })

    function showFeeds() {
        spinner.show()
        setTimeout(async function() {
            if (url) {
                await fetchFeeds()
                console.log(feeds.length)
                if (feeds.length > 0) {
                    feeds.map(feed => {
                        $(generateFeedUi(feed)).appendTo(feedsUi).show().slideDown(500)
                    })
                    spinner.hide()
                }

            } else {
                spinner.hide()
                spinnerContainer.html("<p class='text-xs text-gray-600'>No more feeds</p>")
            }
        }, 1000);


    }

    $(window).scroll(function() {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            showFeeds()
        }
    });

    showFeeds()
</script>

@endsection