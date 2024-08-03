<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\ProductUserReviewFormRequest;
    use App\Models\ProductUserReview;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
     
    class ProductUserReviewController extends Controller {
        
        public function index (): View {
            $data[ 'title' ]   = 'Products Reviews';
            $data[ 'reviews' ] = ProductUserReview ::with ( [ 'product', 'user' ] ) -> latest () -> get ();

            // dd( $data[ 'reviews' ]);
            return view ( 'products.reviews', $data );
        }
        
        public function create () {
            //
        }
        
        public function store ( ProductUserReviewFormRequest $request ) {
            //
        }
        
        public function edit ( ProductUserReview $review ) {
            //
        }
        
        public function update ( ProductUserReviewFormRequest $request, ProductUserReview $review ) {
            try {
                $this->authorize('approve_disapprove', User::class);
                DB ::beginTransaction ();
                $review -> active = $review -> active == '0' ? '1' : '0';
                $review -> update ();
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Review has been updated.' );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( ProductUserReview $review ) {
            try {
                $this->authorize('deletereview', User::class);

                DB ::beginTransaction ();
                $review -> delete ();
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Review has been deleted.' );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function edit_review(Request $request, $id)
        {

            $this->authorize('reviewedit', User::class);

            $request->validate([
               'rating' => 'required|integer|min:1|max:5',
                'review' => 'required|string',
            ]);
        
            // Find the review
            $review = ProductUserReview::findOrFail($id);
        
            // Update review
            $review->update([
                'rating' => $request->input('rating'),
                'review' => $request->input('review'),

            ]);
        
            // Redirect back with success message
            return redirect()->back()->with('success', 'Review updated successfully.');
        }
        

    }
