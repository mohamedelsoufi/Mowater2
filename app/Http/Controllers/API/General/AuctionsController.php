<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AddBidRequest;
use App\Http\Requests\API\ShowAuctionRequest;
use App\Http\Resources\Auctions\AllAuctionsResource;
use App\Http\Resources\Auctions\ShowAuctionResource;
use App\Http\Resources\Auctions\ShowBidResource;
use App\Models\Auction;
use Carbon\Carbon;


class AuctionsController extends Controller
{
    public function index()
    {
        try {
            $auctions = Auction::selection()->latest('id')->search()->paginate(PAGINATION_COUNT);
            return responseJson(1, 'success', AllAuctionsResource::collection($auctions)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show_auction(ShowAuctionRequest $request)
    {
        try {
            $auction = Auction::with('vehicles', 'insurance_company')->find($request->id);

            //update number of views start
            updateNumberOfViews($auction);
            //update number of views end

            return responseJson(1, 'success', new ShowAuctionResource($auction));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function subscribe(ShowAuctionRequest $request)
    {
        try {
            $auction = Auction::find($request->id);

            if ($auction->start_date <= Carbon::now()->format('Y-m-d')) {
                // started
                return responseJson(0, __('message.auction_started_already'));
            }
            if ($auction->end_date >= Carbon::now()->format('Y-m-d')) {
                $user = getAuthAPIUser();

                $request['user_id'] = $user->id;
                $subscription = $user->auctions;
                if ($subscription) {

                    // use wallet to subscribe start
                    useWallet($auction->min_bid);
                    // use wallet to subscribe end

                    $subs = $user->auctions()->where('auction_id', $auction->id)->first();
                    if ($subs) {
                        return responseJson(1, __('message.subscribed_here_already'));
                    }

                    $user->auctions()->attach($request->id);
                    return responseJson(1, __('message.subscription_done'));
                }
            } else {
                return responseJson(0, __('message.auction_ended'));
            }
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function user_subscriptions()
    {
        try {
            $user = getAuthAPIUser();

            $subscripitons = $user->auctions()->search()->paginate(PAGINATION_COUNT);
            return responseJson(1, 'success', AllAuctionsResource::collection($subscripitons)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function add_bid(AddBidRequest $request)
    {
        try {
            $auction = Auction::find($request->auction_id);
            $max_price = $auction->bids()->max('bid_amount');

            $last_bid = $auction->bids()->latest('id')->first();

            $user = getAuthAPIUser();

            $subscription = $user->auctions;
            $subs = "";
            if ($subscription) {
                $subs = $user->auctions()->where('auction_id', $auction->id)->get();
            }

            if (!$subs) {
                return responseJson(0, __('message.not_subscribed'));
            }

            //check minimum auction bid
            if ($auction->min_bid > $request->bid_amount) {
                return responseJson(0, __('message.min_bid'));
            }

            // check user bid twice after each other
            if ($user->id == $last_bid->user_id) {
                return responseJson(0, __('message.duplicate_user_bid'));
            }

            // check max bid amount comparing with existing bid
            if ($max_price >= $request->bid_amount) {
                return responseJson(0, __('message.not_suitable_bid') . __('message.max_bid') . $max_price);
            }

            //check auction if started
            if ($auction->start_date > Carbon::now()->format('Y-m-d')) {
                return responseJson(0, __('message.auction_not_started_yet'));
            }

            //this auction is ended
            if ($auction->end_date < Carbon::now()->format('Y-m-d')) {
                return responseJson(0, __('message.auction_ended_already'));
            }

            // add bid
            $bid = $auction->bids()->create(['user_id' => $user->id,
                'auction_id' => $request->auction_id,
                'bid_amount' => $request->bid_amount]);
            if ($bid) {
                return responseJson(1, __('message.bid_added_successfully'));
            }
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function auctionBids(ShowAuctionRequest $request)
    {
        try {
            $auction = Auction::find($request->id);

            $bids = $auction->bids()->with('user', 'auction')->paginate(PAGINATION_COUNT);
            return responseJson('1', 'success', ShowBidResource::collection($bids)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function UserAuctionBids(ShowAuctionRequest $request)
    {
        try {
            $user = getAuthAPIUser();
            $bids = $user->bids()->with('user', 'auction')->paginate(PAGINATION_COUNT);
            return responseJson('1', 'success', ShowBidResource::collection($bids)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

}

