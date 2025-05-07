```mermaid
graph TD
    A[Student Logs In] --> B{Check Mess Menu?}
    B -- Yes --> C[View Current Menu]
    B -- No --> D{Pre-book Meal?}
    D -- Yes --> E[Select Meal & Submit]
    D -- No --> F[Leave Feedback]

    G[Mess Authority Logs In] --> H{Update Menu?}
    H -- Yes --> I[Upload New Menu]
    H -- No --> J[View Bookings & Feedback]

    E -- Booking Info --> J
    F -- Feedback --> J
    I -- Updated Menu --> C
