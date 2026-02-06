<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;

class OrganizationContextController extends Controller
{
    /**
     * Switch the active organization context for the current user.
     */
    public function switch(Request $request)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
        ]);

        $user = auth()->user();
        
        // Ensure user has an employee profile
        if (!$user->employee) {
            return back()->with('error', 'No employee profile found.');
        }

        // Verify the user is assigned to this organization
        if (!$user->employee->isAssignedTo($request->organization_id)) {
            return back()->with('error', 'You are not assigned to this organization.');
        }

        // Update session
        session(['active_organization_id' => $request->organization_id]);

        return back()->with('success', 'Active organization switched successfully.');
    }
}
